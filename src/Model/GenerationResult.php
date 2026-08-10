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
 * Holds the results of a test data generation run.
 */
class GenerationResult
{
    private int $catalogsGenerated = 0;
    private int $localizedCatalogsGenerated = 0;
    private int $sourceFieldsGenerated = 0;
    private int $sourceFieldOptionsGenerated = 0;
    private int $categoriesGenerated = 0;
    private int $productsGenerated = 0;

    /** @var array<string, int> */
    private array $sourceFieldsByType = [];

    private float $startTime;
    private float $endTime;
    private int $peakMemory = 0;

    public function __construct()
    {
        $this->startTime = microtime(true);
    }

    public function markComplete(): void
    {
        $this->endTime = microtime(true);
        $this->peakMemory = memory_get_peak_usage(true);
    }

    public function addCatalogs(int $count): void
    {
        $this->catalogsGenerated += $count;
    }

    public function addLocalizedCatalogs(int $count): void
    {
        $this->localizedCatalogsGenerated += $count;
    }

    public function addSourceFields(int $count, ?string $type = null): void
    {
        $this->sourceFieldsGenerated += $count;

        if (null !== $type) {
            if (!isset($this->sourceFieldsByType[$type])) {
                $this->sourceFieldsByType[$type] = 0;
            }
            $this->sourceFieldsByType[$type] += $count;
        }
    }

    public function addSourceFieldOptions(int $count): void
    {
        $this->sourceFieldOptionsGenerated += $count;
    }

    public function addCategories(int $count): void
    {
        $this->categoriesGenerated += $count;
    }

    public function addProducts(int $count): void
    {
        $this->productsGenerated += $count;
    }

    public function getCatalogsGenerated(): int
    {
        return $this->catalogsGenerated;
    }

    public function getLocalizedCatalogsGenerated(): int
    {
        return $this->localizedCatalogsGenerated;
    }

    public function getSourceFieldsGenerated(): int
    {
        return $this->sourceFieldsGenerated;
    }

    public function getSourceFieldOptionsGenerated(): int
    {
        return $this->sourceFieldOptionsGenerated;
    }

    public function getCategoriesGenerated(): int
    {
        return $this->categoriesGenerated;
    }

    public function getProductsGenerated(): int
    {
        return $this->productsGenerated;
    }

    /**
     * @return array<string, int>
     */
    public function getSourceFieldsByType(): array
    {
        return $this->sourceFieldsByType;
    }

    public function getExecutionTimeSeconds(): float
    {
        return $this->endTime - $this->startTime;
    }

    public function getPeakMemoryMB(): float
    {
        return round($this->peakMemory / 1024 / 1024, 2);
    }

    public function getFormattedExecutionTime(): string
    {
        $seconds = $this->getExecutionTimeSeconds();

        if ($seconds < 60) {
            return \sprintf('%.2f sec', $seconds);
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds - ($minutes * 60);

        return \sprintf('%d min %.0f sec', $minutes, $remainingSeconds);
    }

    public function getTotalEntitiesGenerated(): int
    {
        return $this->catalogsGenerated
            + $this->localizedCatalogsGenerated
            + $this->sourceFieldsGenerated
            + $this->sourceFieldOptionsGenerated
            + $this->categoriesGenerated
            + $this->productsGenerated;
    }
}
