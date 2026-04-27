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
use Gally\Category\Service\CategoryTreeBuilder;
use Gally\Index\Repository\Index\IndexRepositoryInterface;
use Gally\Index\Service\IndexOperation;
use Gally\Metadata\Repository\MetadataRepository;
use Gally\Metadata\Repository\SourceFieldRepository;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Provider\ProductNameProvider;
use Gally\SampleData\Service\CodeGenerator;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Generates Product entities.
 */
class ProductGenerator extends AbstractEntityGenerator
{
    /** @var int Global product counter per catalog, used to make IDs unique */
    private int $productIdIncrement = 0;

    /** @var array<string> Category paths for round-robin distribution */
    private array $categoryPaths = [];

    /** @var array<mixed> Select source fields available for variants */
    private array $selectSourceFields = [];

    private int $variantRatio = 0;

    public function __construct(
        CodeGenerator $codeGenerator,
        EntityManagerInterface $entityManager,
        IndexOperation $indexOperation,
        CatalogRepository $catalogRepository,
        IndexRepositoryInterface $indexRepository,
        private MetadataRepository $metadataRepository,
        SourceFieldRepository $sourceFieldRepository,
        TranslatorInterface $translator,
        private ProductNameProvider $productNameProvider,
        private CategoryTreeBuilder $categoryTreeBuilder,
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
     * Generate all products, their localized configurations, and their OpenSearch documents.
     */
    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        parent::generateAll($config, $result, $output);
        $result->addProducts($this->generatedEntityCount);
    }

    /**
     * Load leaf categories for the current catalog.
     */
    protected function prepare(GenerationConfig $config, Catalog $catalog): void
    {
        $categoryTree = $this->categoryTreeBuilder->buildTree($catalog->getId(), null);
        $this->categoryPaths = $this->extractLeafCategoryPaths($categoryTree->getCategories());

        // Extract select fields for variants
        $productMetadata = $this->metadataRepository->findOneBy(['entity' => 'product']);
        if ($productMetadata) {
            foreach ($productMetadata->getSourceFields() as $sourceField) {
                if ('select' === $sourceField->getType() && !$sourceField->getOptions()->isEmpty()) {
                    $this->selectSourceFields[] = [
                        'code' => $sourceField->getCode(),
                        'options' => $sourceField->getOptions()->toArray(),
                    ];
                }
            }
        }

        $this->variantRatio = $config->getConfigurableProductPercentage();
    }

    /**
     * Generate a single product document with system fields and localized name.
     */
    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): array|object {
        ++$this->productIdIncrement;

        $this->profiler->start('generate_base_fields');
        $document = parent::generate($config, $result, $output, $index);
        $this->profiler->stop('generate_base_fields');

        $document['price'] = [
            [
                'price' => $this->randomizer->getInt(10, 500),
                'original_price' => $this->randomizer->getInt(10, 500),
                'is_discounted' => false,
                'group_id' => 0,
            ],
        ];

        $document['stock'] = [
            'status' => $this->randomizer->getInt(1, 100) <= 95,
            'qty' => $this->randomizer->getInt(0, 500),
        ];

        $sku = $document['sku'][0];
        $document['sku'] = $sku;
        $categoryPath = $this->selectCategoryPathFromSku($sku);
        $document['category'] = $this->buildCategoryArray($categoryPath);

        if ($this->randomizer->getInt(0, 100) < 5 && \count($this->categoryPaths) > 1) {
            $secondaryCategoryPath = $this->selectCategoryPathFromSku($sku . '_secondary');
            $document['secondary_category'] = $this->buildCategoryArray($secondaryCategoryPath);
        }

        $this->profiler->start('generate_image_and_name');
        $document['image'] = [$this->generatePicsumImagePath($sku)];
        $categoryCodes = $this->getCategoryHierarchyFromPath($categoryPath);
        $document['name'] = $this->productNameProvider->generateProductName($categoryCodes, $sku);
        $this->profiler->stop('generate_image_and_name');

        $isConfigurable = $this->variantRatio > 0 && $this->randomizer->getInt(1, 100) <= $this->variantRatio;

        if ($isConfigurable) {
            $this->profiler->start('generate_variants');
            $document = $this->addVariants($document, $sku);
            $this->profiler->stop('generate_variants');
        }

        return $document;
    }

    /**
     * Add variant data to a configurable product.
     */
    private function addVariants(array $document, string $parentSku): array
    {
        if (empty($this->selectSourceFields)) {
            return $document;
        }

        // Pick 1 or 2 select fields for variants
        $variantFieldCount = $this->randomizer->getInt(1, min(2, \count($this->selectSourceFields)));
        $selectedIndices = array_rand($this->selectSourceFields, $variantFieldCount);
        if (!\is_array($selectedIndices)) {
            $selectedIndices = [$selectedIndices];
        }

        $variantFields = [];
        $variantFieldCodes = [];
        foreach ($selectedIndices as $idx) {
            $variantFields[] = $this->selectSourceFields[$idx];
            $variantFieldCodes[] = $this->selectSourceFields[$idx]['code'];
        }

        // Generate combinations
        $combinations = $this->generateVariantCombinations($variantFields);

        $childrenIds = [];
        $childrenSkus = [];
        $childrenImages = [];
        $childrenUrlKeys = [];

        $urlKey = $document['url_key'][0] ?? strtolower(str_replace(' ', '-', $document['name']));

        foreach ($combinations as $combination) {
            $childId = ++$this->productIdIncrement;
            $childSku = $parentSku . '-' . implode('-', array_map(fn ($v) => str_replace(' ', '', $v), $combination));

            $childrenIds[] = $childId;
            $childrenSkus[] = $childSku;
            $childrenImages[] = $this->generatePicsumImagePath($childSku);
            $childrenUrlKeys[] = $urlKey . '-' . implode('-', array_map(fn ($v) => strtolower(str_replace(' ', '-', $v)), $combination));

            // Add variant field values to document
            foreach ($variantFieldCodes as $idx => $fieldCode) {
                if (!isset($document[$fieldCode])) {
                    $document[$fieldCode] = [];
                }
                $document[$fieldCode][] = [
                    'value' => $combination[$idx],
                    'label' => $combination[$idx],
                ];
            }
        }

        // Remove duplicates from variant fields
        foreach ($variantFieldCodes as $fieldCode) {
            if (isset($document[$fieldCode])) {
                $document[$fieldCode] = array_values(array_unique(
                    array_map(fn ($v) => json_encode($v), $document[$fieldCode]),
                    \SORT_REGULAR
                ));
                $document[$fieldCode] = array_map(fn ($v) => json_decode($v, true), $document[$fieldCode]);
            }
        }

        $document['type_id'] = 'configurable';
        $document['configurable_attributes'] = $variantFieldCodes;
        $document['children_ids'] = $childrenIds;
        $document['children.sku'] = $childrenSkus;
        $document['children.image'] = $childrenImages;
        $document['children.url_key'] = $childrenUrlKeys;
        $document['stock'] = ['qty' => 0, 'status' => true];

        return $document;
    }

    /**
     * Generate all combinations of variant options.
     *
     * @param array<array{code: string, options: array<mixed>}> $variantFields
     *
     * @return array<array<string>>
     */
    private function generateVariantCombinations(array $variantFields): array
    {
        // Pick random options for each field
        $selectedOptions = [];
        foreach ($variantFields as $field) {
            $optionCount = $this->randomizer->getInt(2, min(4, \count($field['options'])));
            $indices = array_rand($field['options'], $optionCount);
            if (!\is_array($indices)) {
                $indices = [$indices];
            }
            $selectedOptions[] = array_map(
                fn ($idx) => $field['options'][$idx]->getDefaultLabel(),
                $indices
            );
        }

        // Generate cartesian product
        return $this->cartesianProduct($selectedOptions);
    }

    /**
     * Generate cartesian product of arrays.
     *
     * @param array<array<string>> $arrays
     *
     * @return array<array<string>>
     */
    private function cartesianProduct(array $arrays): array
    {
        if (empty($arrays)) {
            return [[]];
        }

        $result = [[]];
        foreach ($arrays as $array) {
            $temp = [];
            foreach ($result as $item) {
                foreach ($array as $value) {
                    $temp[] = array_merge($item, [$value]);
                }
            }
            $result = $temp;
        }

        return $result;
    }

    private function generatePicsumImagePath(string $sku): string
    {
        // Set https://picsum.photos/seed/ as base media url
        $seed = crc32($sku) % 1000;

        return \sprintf('%s/400/300', $seed);
    }

    /**
     * Select a category path based on SKU (reproducible randomness).
     */
    private function selectCategoryPathFromSku(string $sku): string
    {
        if (empty($this->categoryPaths)) {
            throw new \RuntimeException('No leaf categories available for product generation');
        }

        $seed = crc32($sku);
        $index = $seed % \count($this->categoryPaths);

        return $this->categoryPaths[$index];
    }

    /**
     * Extract leaf category paths from the tree (categories without children).
     *
     * @param array<mixed> $categories
     *
     * @return array<string>
     */
    private function extractLeafCategoryPaths(array $categories): array
    {
        $leafPaths = [];

        foreach ($categories as $category) {
            if (empty($category['children'])) {
                $leafPaths[] = $category['path'];
            } else {
                $leafPaths = array_merge($leafPaths, $this->extractLeafCategoryPaths($category['children']));
            }
        }

        return $leafPaths;
    }

    /**
     * Get the category hierarchy (codes) from a category path.
     *
     * @return array<string>
     */
    private function getCategoryHierarchyFromPath(string $categoryPath): array
    {
        $codes = [];
        $parts = explode('/', $categoryPath);

        foreach ($parts as $part) {
            if ('root' === $part) {
                continue;
            }
            $codePart = explode('--', $part);
            if (isset($codePart[1])) {
                $codes[] = $codePart[1];
            }
        }

        return $codes;
    }

    /**
     * Build category array with all categories in the path.
     *
     * @return array<mixed>
     */
    private function buildCategoryArray(string $categoryPath): array
    {
        $categories = [];
        $parts = explode('/', $categoryPath);

        foreach ($parts as $part) {
            $categories[] = [
                'id' => $part,
                'name' => null, // Will be filled during localization
            ];
        }

        return $categories;
    }

    protected function localizeDocument(
        array $rawDocument,
        LocalizedCatalog $localizedCatalog,
    ): array {
        $this->profiler->start('localize_document_product');
        $document = parent::localizeDocument($rawDocument, $localizedCatalog);
        $document['name'] = [$this->translateName($document['name'], $localizedCatalog)];
        $this->profiler->stop('localize_document_product');

        return $document;
    }

    protected function getEntityCode(): string
    {
        return 'product';
    }

    protected function getSourceFieldsProportion(): int
    {
        return 10;
    }

    protected function getCount(GenerationConfig $config): int
    {
        return $config->getProducts();
    }
}
