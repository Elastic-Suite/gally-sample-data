<?php

/**
 * DISCLAIMER.
 *
 * Do not edit or add to this file if you wish to upgrade Gally to newer versions in the future.
 *
 * @author    Gally Team <elasticsuite@smile.fr>
 * @copyright 2022-present Smile
 * @license   Open Software License v. 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace Gally\SampleData\Generator;

use Doctrine\ORM\EntityManagerInterface;
use Gally\Catalog\Entity\Catalog;
use Gally\Catalog\Entity\LocalizedCatalog;
use Gally\Catalog\Repository\CatalogRepository;
use Gally\Index\Dto\Bulk;
use Gally\Index\Repository\Index\IndexRepositoryInterface;
use Gally\Index\Service\IndexOperation;
use Gally\Metadata\Entity\Metadata;
use Gally\Metadata\Entity\SourceField;
use Gally\Metadata\Entity\SourceField\Type;
use Gally\Metadata\Entity\SourceFieldOption;
use Gally\Metadata\Repository\MetadataRepository;
use Gally\Metadata\Repository\SourceFieldRepository;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Service\CodeGenerator;
use Gally\SampleData\Service\GenerationProfiler;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Generates entities.
 */
abstract class AbstractEntityGenerator extends AbstractGenerator
{
    protected Catalog $currentCatalog;

    /** @var array<SourceField>|null Cached source fields for metadata */
    protected ?array $sourceFields = null;

    /** @var array<int, \Gally\Index\Entity\Index> Indices indexed by localized catalog id for the current catalog */
    protected array $currentIndices = [];

    protected int $generatedEntityCount = 0;

    /** @var array<int, array<int, string>> Cache: [optionId][localizedCatalogId] => label */
    private array $labelCache = [];

    /** @var array<int, true> Option IDs collected during generate(), to be resolved in persistBatch() */
    private array $pendingOptionIds = [];

    protected GenerationProfiler $profiler;

    protected int $parrallelBulkCount = 0;

    public function __construct(
        CodeGenerator $codeGenerator,
        protected EntityManagerInterface $entityManager,
        protected IndexOperation $indexOperation,
        protected CatalogRepository $catalogRepository,
        private IndexRepositoryInterface $indexRepository,
        private MetadataRepository $metadataRepository,
        private SourceFieldRepository $sourceFieldRepository,
        private TranslatorInterface $translator,
    ) {
        parent::__construct($codeGenerator);
        $this->profiler = new GenerationProfiler();
    }

    /**
     * Generate all categories, their localized configurations, and their OpenSearch documents.
     */
    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        $this->profiler->reset();

        foreach ($this->catalogRepository->findAll() as $catalog) {
            $this->entityManager->refresh($catalog);

            $this->setRandomizerCode($config->getSeed() ^ crc32($catalog->getCode()));
            $this->currentCatalog = $catalog;

            // Create entity index for the current catalog
            $this->profiler->start('index_creation');
            $metadata = $this->getMetadata();
            $this->currentIndices = [];
            foreach ($this->currentCatalog->getLocalizedCatalogs() as $localizedCatalog) {
                $this->currentIndices[$localizedCatalog->getId()] = $this->indexOperation->createEntityIndex($metadata, $localizedCatalog);
            }
            $this->profiler->stop('index_creation');

            $this->profiler->start('prepare');
            $this->prepare($config, $catalog);
            $this->profiler->stop('prepare');

            $total = $this->getCount($config);
            $batchSize = $this->getBatchSize($config);
            $progressBar = $this->createProgressBar(
                $output,
                $total,
                \sprintf('%d %s for catalog %s', $total, $this->getEntityName(), $catalog->getCode())
            );
            $progressBar->start();

            $batch = [];
            for ($index = 0; $index < $total; ++$index) {
                $this->profiler->start('generate');
                $batch[] = $this->generate($config, $result, $output, $index);
                $this->profiler->stop('generate');

                $progressBar->advance();

                if (\count($batch) >= $batchSize) {
                    $this->persistBatch($batch);
                    $batch = [];
                    if ($output->isVerbose()) {
                        $output->writeln('');
                    }
                }
            }

            if (!empty($batch)) {
                $this->persistBatch($batch);
            }
            $this->profiler->start('install_index');
            foreach ($this->currentIndices as $index) {
                $this->indexOperation->installIndexByName($index->getName());
            }
            $this->profiler->stop('install_index');

            $progressBar->finish();
            $output->writeln('');
        }

        $this->profiler->start('oensearch_waitfor');
        $responses = $this->indexRepository->resolveFutureBulks();
        $this->parrallelBulkCount = 0;
        $this->profiler->stop('oensearch_waitfor');

        foreach ($responses as $response) {
            $this->generatedEntityCount += \count($response->getSuccessItems());
            if ($response->hasErrors()) {
                throw new \RuntimeException(\sprintf('Bulk indexing failed: %s', json_encode($response->aggregateErrorsByReason())));
            }
        }

        $this->profiler->dump($output, $this->getEntityName());
    }

    protected function prepare(GenerationConfig $config, Catalog $catalog): void
    {
    }

    /**
     * Generate a single entity or raw data array.
     */
    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): array|object {
        // Create a unique randomizer for this entity
        $entitySeed = crc32($this->currentCatalog->getCode() . '_' . $this->getEntityCode() . '_' . $index);
        $this->setRandomizerCode($entitySeed);

        $document = [
            'id' => $this->currentCatalog->getCode() . '_' . $index,
            '_selectFields' => [],
        ];

        foreach ($this->getSourceFields() as $sourceField) {
            $code = $sourceField->getCode();

            if (\in_array($code, ['id', 'name'], true)) {
                continue;
            }

            if (
                !$sourceField->getIsSystem()
                && $this->randomizer->getInt(0, 100) > $this->getSourceFieldsProportion()
            ) {
                continue;
            }

            $this->profiler->start('generate_field_value');
            $value = $this->generateFieldValue($sourceField);
            $this->profiler->stop('generate_field_value');

            $document[$code] = $value;

            if (\in_array($sourceField->getType(), [Type::TYPE_SELECT], true)) {
                $document['_selectFields'][] = $code;
            }
        }

        return $document;
    }

    protected function getSourceFieldsProportion(): int
    {
        return 100;
    }

    abstract protected function getEntityCode(): string;

    protected function getMetadata(): Metadata
    {
        return $this->metadataRepository->findByEntity($this->getEntityCode());
    }

    protected function getEntityName(): string
    {
        return $this->getMetadata()->getEntity();
    }

    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    /**
     * @param array<array<string, mixed>> $batch
     */
    protected function persistBatch(array $batch): void
    {
        /** @var array<int, Bulk\Request> $bulkRequests */
        $bulkRequests = [];
        $localizedCatalogs = $this->currentCatalog->getLocalizedCatalogs();

        // Build label cache from already-collected option IDs
        $this->profiler->start('build_label_cache');
        $this->buildLabelCache($localizedCatalogs);
        $this->profiler->stop('build_label_cache');

        foreach ($batch as $document) {
            $this->profiler->start('localize_document');
            foreach ($localizedCatalogs as $localizedCatalog) {
                $localizedCatalogId = $localizedCatalog->getId();
                $bulkRequests[$localizedCatalogId] ??= new Bulk\Request();
                $bulkRequests[$localizedCatalogId]->addDocument(
                    $this->currentIndices[$localizedCatalogId],
                    $document['id'],
                    $this->localizeDocument($document, $localizedCatalog)
                );
            }
            $this->profiler->stop('localize_document');
        }

        foreach ($bulkRequests as $localizedCatalogId => $bulkRequest) {
            $this->profiler->start('opensearch_bulk');
            $response = $this->indexRepository->bulk($bulkRequest);
            $this->generatedEntityCount += \count($response->getSuccessItems());
            if ($response->hasErrors()) {
                throw new \RuntimeException(\sprintf('Bulk indexing failed: %s', json_encode($response->aggregateErrorsByReason())));
            }
            $this->profiler->stop('opensearch_bulk');
            // $this->profiler->start('opensearch_async_bulk');
            // $this->indexRepository->bulkAsync($bulkRequest);
            // ++$this->parrallelBulkCount;
            // $this->profiler->stop('opensearch_async_bulk');

            if ($this->parrallelBulkCount >= 10) {
                $this->profiler->start('opensearch_waitfor');
                $responses = $this->indexRepository->resolveFutureBulks();
                $this->parrallelBulkCount = 0;
                $this->profiler->stop('opensearch_waitfor');

                foreach ($responses as $response) {
                    $this->generatedEntityCount += \count($response->getSuccessItems());
                    if ($response->hasErrors()) {
                        throw new \RuntimeException(\sprintf('Bulk indexing failed: %s', json_encode($response->aggregateErrorsByReason())));
                    }
                }
            }
        }
    }

    /**
     * @param iterable<LocalizedCatalog> $localizedCatalogs
     */
    private function buildLabelCache(iterable $localizedCatalogs): void
    {
        $this->labelCache = [];

        if (empty($this->pendingOptionIds)) {
            return;
        }

        $localizedCatalogIds = [];
        foreach ($localizedCatalogs as $localizedCatalog) {
            $localizedCatalogIds[] = $localizedCatalog->getId();
        }

        // Query scalars only — no entity hydration, no UnitOfWork pollution
        $optionIds = array_keys($this->pendingOptionIds);
        $optionPlaceholders = implode(',', array_fill(0, \count($optionIds), '?'));
        $catalogPlaceholders = implode(',', array_fill(0, \count($localizedCatalogIds), '?'));

        // We need a native sql query here because doctrine cache will create memory leak.
        $sql = \sprintf(
            'SELECT source_field_option_id AS option_id,
                    localized_catalog_id   AS localized_catalog_id,
                    label
             FROM source_field_option_label
             WHERE source_field_option_id IN (%s)
               AND localized_catalog_id   IN (%s)',
            $optionPlaceholders,
            $catalogPlaceholders
        );

        /** @var \PDO $nativeConnection */
        $nativeConnection = $this->entityManager->getConnection()->getNativeConnection();
        $stmt = $nativeConnection->prepare($sql);

        $stmt->execute([...$optionIds, ...$localizedCatalogIds]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        unset($stmt);

        foreach ($rows as $row) {
            $this->labelCache[(int) $row['option_id']][(int) $row['localized_catalog_id']] = $row['label'];
        }

        $this->pendingOptionIds = [];
    }

    /**
     * Produce a fully localized, OpenSearch-ready document from a raw document.
     *
     * @param array<string, mixed> $rawDocument
     *
     * @return array<string, mixed>
     */
    protected function localizeDocument(
        array $rawDocument,
        LocalizedCatalog $localizedCatalog,
    ): array {
        $selectFields = $rawDocument['_selectFields'];
        unset($rawDocument['_selectFields']);

        $document = $rawDocument;

        foreach ($selectFields as $code) {
            if (!isset($document[$code])) {
                continue;
            }

            $values = $document[$code];

            $this->profiler->start('localize_select_options');
            $document[$code] = array_map(
                function (mixed $entry) use ($localizedCatalog): mixed {
                    if (!$entry instanceof SourceFieldOption) {
                        return $entry;
                    }

                    return [
                        'value' => $entry->getCode(),
                        'label' => $this->labelCache[$entry->getId()][$localizedCatalog->getId()] ?? $entry->getDefaultLabel(),
                    ];
                },
                \is_array($values) ? $values : [$values]
            );
            $this->profiler->stop('localize_select_options');
        }

        return $document;
    }

    protected function generateFieldValue(SourceField $sourceField): mixed
    {
        $count = $this->randomizer->getInt(1, 3);
        $values = [];
        for ($i = 0; $i < $count; ++$i) {
            switch ($sourceField->getType()) {
                case Type::TYPE_SELECT:
                    $this->profiler->start('fetch_options');
                    $options = $sourceField->getOptions()->getValues();
                    $this->profiler->stop('fetch_options');

                    if (empty($options)) {
                        break;
                    }

                    $option = $options[$this->randomizer->pickArrayKeys($options, 1)[0]];
                    $this->pendingOptionIds[$option->getId()] = true;
                    $values[] = $option;
                    break;
                case Type::TYPE_BOOLEAN:
                    $values[] = (bool) $this->randomizer->getInt(0, 1);
                    break;
                case Type::TYPE_INT:
                    $values[] = $this->randomizer->getInt(0, 100);
                    break;
                case Type::TYPE_FLOAT:
                case Type::TYPE_PRICE:
                    $values[] = round($this->randomizer->getInt(0, 10000) / 100, 2);
                    break;
                case Type::TYPE_DATE:
                    $values[] = (new \DateTime('-' . $this->randomizer->getInt(0, 365) . ' days'))->format('Y-m-d');
                    break;
                case Type::TYPE_LOCATION:
                    $values[] = $this->randomizer->getInt(-90, 90) . ',' . $this->randomizer->getInt(-180, 180);
                    break;
                default:
                    $values[] = bin2hex($this->randomizer->getBytes(8));
            }
        }

        return $values;
    }

    /**
     * @return array<SourceField>
     */
    protected function getSourceFields(): array
    {
        if (null === $this->sourceFields) {
            $this->profiler->start('fetch_source_fields');
            $metadata = $this->getMetadata();
            $this->sourceFields = $this->sourceFieldRepository->findBy(['metadata' => $metadata]);
            $this->profiler->stop('fetch_source_fields');
        }

        return $this->sourceFields;
    }

    protected function translateName(string $text, LocalizedCatalog $localizedCatalog): string
    {
        $keys = explode(' ', $text);
        $translatedParts = array_map(function (string $key) use ($localizedCatalog): string {
            $translated = $this->translator->trans($key, [], $this->getEntityName(), $localizedCatalog->getLocale());

            return $translated !== $key ? $translated : $key;
        }, $keys);

        return implode(' ', $translatedParts);
    }
}
