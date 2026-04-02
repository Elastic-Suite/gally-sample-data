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

use Gally\Catalog\Entity\LocalizedCatalog;
use Gally\Catalog\Repository\LocalizedCatalogRepository;
use Gally\Metadata\Entity\Metadata;
use Gally\Metadata\Entity\SourceField\Type;
use Gally\Metadata\Repository\MetadataRepository;
use Gally\Metadata\State\SourceFieldProcessor;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Provider\FieldTypeProvider;
use Gally\SampleData\Service\CodeGenerator;
use Gally\SampleData\Service\LabelTranslator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates SourceField entities with realistic distribution by type.
 * Also generates SourceFieldOption and SourceFieldOptionLabel for select fields.
 */
class SourceFieldGenerator extends AbstractGenerator
{
    /** @var array<string, string> System fields that must always exist (from migration) */
    private const SYSTEM_FIELDS = [
        'id' => Type::TYPE_REFERENCE,
        'sku' => Type::TYPE_REFERENCE,
        'category' => Type::TYPE_CATEGORY,
        'name' => Type::TYPE_TEXT,
        'price' => Type::TYPE_PRICE,
        'image' => Type::TYPE_IMAGE,
        'stock' => Type::TYPE_STOCK,
        'description' => Type::TYPE_TEXT,
    ];

    private Metadata $currentMetadata;
    private string $entityName = 'source fields';

    /** @var array<LocalizedCatalog> Localized catalogs cache */
    private array $localizedCatalogs = [];

    public function __construct(
        CodeGenerator $codeGenerator,
        private FieldTypeProvider $fieldTypeProvider,
        private MetadataRepository $metadataRepository,
        private LocalizedCatalogRepository $localizedCatalogRepository,
        private SourceFieldProcessor $sourceFieldProcessor,
        private LabelTranslator $labelTranslator,
        private string $routePrefix,
    ) {
        parent::__construct($codeGenerator);
        $this->routePrefix = $this->routePrefix ? '/' . $this->routePrefix : '';
    }

    protected function getEntityName(): string
    {
        return $this->entityName;
    }

    /**
     * Override generateAll to iterate over each metadata entity separately.
     */
    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        $metadataList = $this->metadataRepository->findAll();
        $this->localizedCatalogs = $this->localizedCatalogRepository->findAll();

        foreach ($metadataList as $metadata) {
            if ('tracking_event' === $metadata->getEntity()) {
                continue;
            }

            $this->currentMetadata = $metadata;
            $this->entityName = 'sourceFields for ' . $metadata->getEntity();

            $count = $this->resolveCountForMetadata($metadata, $config);

            $batchSize = $config->getBatchSize();
            $progressBar = $this->createProgressBar($output, $count, \sprintf('%d %s', $count, $this->getEntityName()));
            $progressBar->start();

            $batch = [];

            for ($i = 0; $i < $count; ++$i) {
                $batch[] = $this->generate($config, $result, $output, $i);
                $progressBar->advance();

                if (\count($batch) >= $batchSize) {
                    $this->persistBatch($batch);
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                $this->persistBatch($batch);
            }

            $progressBar->finish();
            $output->writeln('');
        }
    }

    protected function getCount(GenerationConfig $config): int
    {
        return $this->resolveCountForMetadata($this->currentMetadata, $config);
    }

    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    /**
     * @return array<string, mixed>
     */
    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): array {
        $type = $this->fieldTypeProvider->getRandomType();
        $template = $this->fieldTypeProvider->getRandomTemplateForType($type);

        $code = $this->codeGenerator->generateUniqueCode($template['code']);
        $defaultLabel = $template['label'];

        $result->addSourceFields(1);

        return [
            'metadata' => $this->routePrefix . '/metadata/' . $this->currentMetadata->getId(),
            'code' => $code,
            'type' => $type,
            'defaultLabel' => $defaultLabel,
            'isSearchable' => \in_array($type, [Type::TYPE_TEXT, Type::TYPE_SELECT], true) && random_int(1, 100) <= $config->getSearchablePercentage(),
            'isFilterable' => random_int(1, 100) <= $config->getFilterablePercentage(),
            'isSortable' => false,
            'labels' => $this->generateLabels($defaultLabel, $this->localizedCatalogs),
        ];
    }

    /**
     * @param array<array<string, mixed>> $batch
     */
    protected function persistBatch(array $batch): void
    {
        $this->sourceFieldProcessor->persistMultiple($batch);
    }

    private function resolveCountForMetadata(Metadata $metadata, GenerationConfig $config): int
    {
        return match ($metadata->getEntity()) {
            'product' => $config->getSourceFields(),
            default => random_int(10, 20),
        };
    }

    /**
     * @param array<LocalizedCatalog> $localizedCatalogs
     *
     * @return array<array<string, string>>
     */
    private function generateLabels(string $defaultLabel, array $localizedCatalogs): array
    {
        $translations = $this->labelTranslator->getTranslations($defaultLabel, 'source_fields');

        $labels = [];
        foreach ($localizedCatalogs as $catalog) {
            $locale = $catalog->getLocale();

            if (!\in_array($locale, LabelTranslator::SUPPORTED_LOCALES, true)) {
                continue;
            }

            if (!isset($translations[$locale])) {
                continue;
            }

            $labels[] = [
                'localizedCatalog' => $this->routePrefix . '/localized_catalogs/' . $catalog->getId(),
                'label' => $translations[$locale],
            ];
        }

        return $labels;
    }

    /**
     * Get the list of system field codes.
     *
     * @return array<string>
     */
    public static function getSystemFieldCodes(): array
    {
        return array_keys(self::SYSTEM_FIELDS);
    }
}
