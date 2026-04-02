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

namespace Gally\SampleData\Model;

/**
 * Configuration for test data generation.
 */
class GenerationConfig
{
    public const PRESET_SMALL = 'small';
    public const PRESET_MEDIUM = 'medium';
    public const PRESET_LARGE = 'large';
    public const PRESET_ENTERPRISE = 'enterprise';

    public const PRESETS = [
        self::PRESET_SMALL => [
            'catalogs' => 1,
            'locales_per_catalog' => 2,
            'source_fields' => 100,
            'max_options_per_field' => 100,
            'categories' => 50,
            'max_category_depth' => 3,
            'products' => 1000,
        ],
        self::PRESET_MEDIUM => [
            'catalogs' => 3,
            'locales_per_catalog' => 3,
            'source_fields' => 500,
            'max_options_per_field' => 500,
            'categories' => 1000,
            'max_category_depth' => 4,
            'products' => 50000,
        ],
        self::PRESET_LARGE => [
            'catalogs' => 5,
            'locales_per_catalog' => 4,
            'source_fields' => 2000,
            'max_options_per_field' => 1000,
            'categories' => 2000,
            'max_category_depth' => 5,
            'products' => 100000,
        ],
        self::PRESET_ENTERPRISE => [
            'catalogs' => 10,
            'locales_per_catalog' => 5,
            'source_fields' => 5000,
            'max_options_per_field' => 10000,
            'categories' => 10000,
            'max_category_depth' => 6,
            'products' => 500000,
        ],
    ];

    public function __construct(
        private int $catalogs = 3,
        private int $localesPerCatalog = 2,
        private int $sourceFields = 2000,
        private int $categories = 200,
        private int $products = 100000,
        private int $batchSize = 1000,
        private int $maxOptionsPerField = 100,
        private int $maxCategoryDepth = 3,
        private int $configurableProductPercentage = 20,
        private ?int $seed = null,
        private int $filterablePercentage = 10,
        private int $searchablePercentage = 100,
    ) {
    }

    public static function fromPreset(string $preset): self
    {
        if (!isset(self::PRESETS[$preset])) {
            throw new \InvalidArgumentException(\sprintf('Invalid preset "%s". Available presets: %s', $preset, implode(', ', array_keys(self::PRESETS))));
        }

        $config = self::PRESETS[$preset];

        return new self(
            catalogs: $config['catalogs'],
            localesPerCatalog: $config['locales_per_catalog'],
            sourceFields: $config['source_fields'],
            maxOptionsPerField: $config['max_options_per_field'],
            categories: $config['categories'],
            maxCategoryDepth: $config['max_category_depth'],
            products: $config['products'],
        );
    }

    public function getCatalogs(): int
    {
        return $this->catalogs;
    }

    public function setCatalogs(int $catalogs): self
    {
        $this->catalogs = $catalogs;

        return $this;
    }

    public function getLocalesPerCatalog(): int
    {
        return $this->localesPerCatalog;
    }

    public function setLocalesPerCatalog(int $localesPerCatalog): self
    {
        $this->localesPerCatalog = $localesPerCatalog;

        return $this;
    }

    public function getSourceFields(): int
    {
        return $this->sourceFields;
    }

    public function setSourceFields(int $sourceFields): self
    {
        $this->sourceFields = $sourceFields;

        return $this;
    }

    public function getCategories(): int
    {
        return $this->categories;
    }

    public function setCategories(int $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getProducts(): int
    {
        return $this->products;
    }

    public function setProducts(int $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getBatchSize(): int
    {
        return $this->batchSize;
    }

    public function setBatchSize(int $batchSize): self
    {
        $this->batchSize = $batchSize;

        return $this;
    }

    public function getMaxOptionsPerField(): int
    {
        return $this->maxOptionsPerField;
    }

    public function setMaxOptionsPerField(int $maxOptionsPerField): self
    {
        $this->maxOptionsPerField = $maxOptionsPerField;

        return $this;
    }

    public function getMaxCategoryDepth(): int
    {
        return $this->maxCategoryDepth;
    }

    public function setMaxCategoryDepth(int $maxCategoryDepth): self
    {
        $this->maxCategoryDepth = $maxCategoryDepth;

        return $this;
    }

    public function getSeed(): ?int
    {
        if (!$this->seed) {
            $this->seed = crc32((string) random_int(0, 100000));
        }

        return $this->seed;
    }

    public function setSeed(?int $seed): self
    {
        $this->seed = $seed;

        return $this;
    }

    public function getConfigurableProductPercentage(): int
    {
        return $this->configurableProductPercentage;
    }

    public function setConfigurableProductPercentage(int $configurableProductPercentage): self
    {
        $this->configurableProductPercentage = $configurableProductPercentage;

        return $this;
    }

    public function getFilterablePercentage(): int
    {
        return $this->filterablePercentage;
    }

    public function setFilterablePercentage(int $filterablePercentage): self
    {
        $this->filterablePercentage = $filterablePercentage;

        return $this;
    }

    public function getSearchablePercentage(): int
    {
        return $this->searchablePercentage;
    }

    public function setSearchablePercentage(int $searchablePercentage): self
    {
        $this->searchablePercentage = $searchablePercentage;

        return $this;
    }
}
