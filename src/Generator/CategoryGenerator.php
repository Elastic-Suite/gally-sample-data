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
use Gally\Category\Entity\Category;
use Gally\Category\Entity\Category\Configuration;
use Gally\Index\Dto\Bulk;
use Gally\Index\Repository\Index\IndexRepositoryInterface;
use Gally\Index\Service\IndexOperation;
use Gally\Metadata\Repository\MetadataRepository;
use Gally\Metadata\Repository\SourceFieldRepository;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Provider\CategoryHierarchyProvider;
use Gally\SampleData\Service\CodeGenerator;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Generates Category entities.
 */
class CategoryGenerator extends AbstractEntityGenerator
{
    private array $nodeList = [];

    /** @var int Global category counter per catalog, used to make IDs unique */
    private int $categoryCounter = 0;

    public function __construct(
        CodeGenerator $codeGenerator,
        EntityManagerInterface $entityManager,
        IndexOperation $indexOperation,
        private CategoryHierarchyProvider $categoryHierarchyProvider,
        CatalogRepository $catalogRepository,
        private IndexRepositoryInterface $indexRepository,
        MetadataRepository $metadataRepository,
        SourceFieldRepository $sourceFieldRepository,
        TranslatorInterface $translator,
    ) {
        parent::__construct(
            $codeGenerator,
            $entityManager,
            $indexOperation,
            $catalogRepository,
            $indexRepository,
            $metadataRepository,
            $sourceFieldRepository,
            $translator,
        );
    }

    /**
     * Generate all categories, their localized configurations, and their OpenSearch documents.
     */
    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        parent::generateAll($config, $result, $output);

        $result->addCategories($this->generatedEntityCount);
    }

    protected function getEntityCode(): string
    {
        return 'category';
    }

    protected function prepare(GenerationConfig $config, Catalog $catalog): void
    {
        $this->nodeList = $this->flattenHierarchy(
            [
                [
                    'code' => 'root',
                    'suffix' => $catalog->getCode(),
                    'children' => $this->categoryHierarchyProvider->generateHierarchy(
                        $config->getCategories() - 1,
                        $config->getMaxCategoryDepth(),
                        $config->getSeed() ^ crc32($catalog->getCode()),
                    ),
                ],
            ],
            $catalog->getCode(),
        );
    }

    /**
     * Not used directly — CategoryGenerator handles its own persistence via EntityManager.
     */
    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): array|object {
        $categoryData = $this->nodeList[$index];
        $category = new Category();
        $category->setId($categoryData['id']);
        $category->setParentId($categoryData['parentId']);
        $category->setLevel($categoryData['level']);
        $category->setPath($categoryData['path']);

        $document = parent::generate($config, $result, $output, $index);
        $document['name'] = 'gally.category.' . $categoryData['code'] . ' ' . $categoryData['suffix'];

        $this->entityManager->persist($category);

        return [
            'document' => $document,
            'category' => $category,
        ];
    }

    /**
     * @param array<array<string, mixed>> $batch
     */
    protected function persistBatch(array $batch): void
    {
        $bulkRequest = new Bulk\Request();

        foreach ($batch as ['document' => $document, 'category' => $category]) {
            foreach ($this->currentCatalog->getLocalizedCatalogs() as $localizedCatalog) {
                $index = $this->currentIndices[$localizedCatalog->getId()];

                $this->profiler->start('localize_document');
                $localizedDoc = $this->localizeDocument($document, $localizedCatalog);
                $this->profiler->stop('localize_document');

                $configuration = new Configuration();
                $configuration->setCategory($category);
                $configuration->setCatalog($localizedCatalog->getCatalog());
                $configuration->setLocalizedCatalog($localizedCatalog);
                $configuration->setIsActive(true);
                $configuration->setName($localizedDoc['name'][0]);

                $this->entityManager->persist($configuration);

                $bulkRequest->addDocument($index, $category->getId(), $localizedDoc);
            }
        }

        $this->profiler->start('doctrine_flush');
        $this->entityManager->flush();
        $this->profiler->stop('doctrine_flush');

        $this->profiler->start('opensearch_bulk');
        $response = $this->indexRepository->bulk($bulkRequest);
        $this->generatedEntityCount += $response->countSuccess();
        $this->profiler->stop('opensearch_bulk');

        if ($response->hasErrors()) {
            throw new \RuntimeException(\sprintf('Bulk indexing failed: %s', json_encode($response->aggregateErrorsByReason())));
        }
    }

    protected function getCount(GenerationConfig $config): int
    {
        return \count($this->nodeList);
    }

    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    protected function localizeDocument(
        array $rawDocument,
        LocalizedCatalog $localizedCatalog,
    ): array {
        $document = parent::localizeDocument($rawDocument, $localizedCatalog);
        $document['name'] = [$this->translateName($document['name'], $localizedCatalog)];

        return $document;
    }

    /**
     * @param array<array{code: string, suffix: string, children: array<mixed>}> $nodes
     *
     * @return array<array{category: Category, nodeKey: string, suffix: string}>
     */
    private function flattenHierarchy(
        array $nodes,
        string $catalogCode,
        int $level = 1,
        ?string $parentId = null,
        ?string $parentPath = null,
    ): array {
        $categories = [];

        foreach ($nodes as $node) {
            $counter = ++$this->categoryCounter;
            $id = $catalogCode . '_' . $counter . '--' . $node['code'];
            $path = $parentPath ? "{$parentPath}/{$id}" : $id;
            $categories[] = [
                'id' => $id,
                'path' => $path,
                'parentId' => $parentId,
                'level' => $level,
                'code' => $node['code'],
                'suffix' => '' !== $node['suffix'] ? ' #' . $node['suffix'] : '',
            ];

            if (!empty($node['children'])) {
                $categories = array_merge(
                    $categories,
                    $this->flattenHierarchy(
                        $node['children'],
                        $catalogCode,
                        $level + 1,
                        $id,
                        $path,
                    )
                );
            }
        }

        return $categories;
    }
}
