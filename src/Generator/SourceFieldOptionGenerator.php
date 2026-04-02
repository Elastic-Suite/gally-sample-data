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

use Gally\Catalog\Repository\LocalizedCatalogRepository;
use Gally\Metadata\Repository\SourceFieldRepository;
use Gally\Metadata\State\SourceFieldOptionProcessor;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Provider\FieldTypeProvider;
use Gally\SampleData\Service\CodeGenerator;
use Gally\SampleData\Service\LabelTranslator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates SourceFieldOption entities for SELECT type source fields.
 * Reads existing SourceFields from database and persists options in batches
 * via SourceFieldOptionProcessor::persistMultiple().
 */
class SourceFieldOptionGenerator extends AbstractGenerator
{
    /**
     * Predefined option values for common select field types.
     * Keys must match (or be contained in) the source field code.
     */
    private const OPTION_VALUES = [
        'brand' => ['Nike', 'Adidas', 'Apple', 'Samsung', 'Sony', 'LG', 'Dell', 'HP', 'Lenovo', 'Asus', 'Canon', 'Nikon', 'Bosch', 'Philips', 'Panasonic', 'Siemens', 'Whirlpool', 'Electrolux', 'Miele', 'Dyson'],
        'color' => ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White', 'Gray', 'Orange', 'Purple', 'Pink', 'Brown', 'Beige', 'Navy', 'Turquoise', 'Maroon'],
        'size' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '28', '30', '32', '34', '36', '38', '40', '42', '44'],
        'material' => ['Cotton', 'Polyester', 'Wool', 'Silk', 'Leather', 'Denim', 'Linen', 'Nylon', 'Spandex', 'Velvet', 'Cashmere', 'Suede', 'Canvas'],
        'manufacturer' => ['Manufacturer A', 'Manufacturer B', 'Manufacturer C', 'Manufacturer D', 'Manufacturer E', 'Manufacturer F', 'Manufacturer G', 'Manufacturer H'],
        'gender' => ['Male', 'Female', 'Unisex'],
        'style' => ['Classic', 'Modern', 'Vintage', 'Casual', 'Formal', 'Sporty', 'Elegant', 'Minimalist'],
        'pattern' => ['Solid', 'Striped', 'Checkered', 'Floral', 'Geometric', 'Abstract', 'Polka Dot', 'Plaid'],
        'season' => ['Spring', 'Summer', 'Autumn', 'Winter'],
        'country_of_manufacture' => ['France', 'Germany', 'Italy', 'Spain', 'United Kingdom', 'United States', 'Canada', 'China', 'Japan', 'South Korea'],
        'certification' => ['CE', 'ISO 9001', 'Energy Star', 'Eco Label', 'Fair Trade'],
        'warranty' => ['6 months', '1 year', '2 years', '3 years', '5 years'],
        'collection' => ['Spring 2024', 'Summer 2024', 'Autumn 2024', 'Winter 2024', 'Limited Edition', 'Classic', 'Premium', 'Essential'],
    ];

    /** @var array<string, int> Tracks how many fields fell into each distribution bucket */
    private array $distributionTracker = [
        'small' => 0, // 2-20 options   (80%)
        'medium' => 0, // 20-50 options  (15%)
        'large' => 0, // 50-80% of max  ( 4%)
        'max' => 0, // 80-100% of max ( 1%)
    ];

    private int $totalSelectFields = 0;

    private string $routePrefix;

    public function __construct(
        CodeGenerator $codeGenerator,
        private SourceFieldRepository $sourceFieldRepository,
        private LocalizedCatalogRepository $localizedCatalogRepository,
        private SourceFieldOptionProcessor $sourceFieldOptionProcessor,
        private FieldTypeProvider $fieldTypeProvider,
        private LabelTranslator $labelTranslator,
        string $routePrefix,
    ) {
        parent::__construct($codeGenerator);
        $this->routePrefix = $routePrefix ? '/' . $routePrefix : '';
    }

    protected function getEntityName(): string
    {
        return 'source field options';
    }

    protected function getCount(GenerationConfig $config): int
    {
        return $this->totalSelectFields;
    }

    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    /**
     * Not used directly — generateAll() iterates per source field.
     * Options are built in bulk per field, not one by one.
     */
    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): array {
        return [];
    }

    /**
     * @param array<array<string, mixed>> $batch
     */
    protected function persistBatch(array $batch): void
    {
        $this->sourceFieldOptionProcessor->persistMultiple($batch);
    }

    /**
     * Generate options for all SELECT source fields found in the database.
     * Persists in batches via SourceFieldOptionProcessor::persistMultiple().
     */
    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        $localizedCatalogs = $this->localizedCatalogRepository->findAll();

        $selectSourceFields = $this->sourceFieldRepository->findBy([
            'type' => FieldTypeProvider::TYPE_SELECT,
        ]);

        $total = \count($selectSourceFields);

        if (0 === $total) {
            $output->writeln('<comment>No SELECT source fields found, skipping option generation.</comment>');

            return;
        }

        $this->distributionTracker = ['small' => 0, 'medium' => 0, 'large' => 0, 'max' => 0];
        $this->totalSelectFields = $total;

        $progressBar = $this->createProgressBar($output, $total, \sprintf('options for %d SELECT source fields', $total));
        $progressBar->start();

        $batch = [];
        $batchSize = $config->getBatchSize();
        $processedCount = 0;

        foreach ($selectSourceFields as $sourceField) {
            ++$processedCount;
            $isLast = ($processedCount === $total);

            $options = $this->buildRawOptionsForField(
                $sourceField->getId(),
                $sourceField->getCode(),
                $localizedCatalogs,
                $config,
                $isLast,
            );

            foreach ($options as $option) {
                $batch[] = $option;
                $result->addSourceFieldOptions(1);

                if (\count($batch) >= $batchSize) {
                    $this->persistBatch($batch);
                    $batch = [];
                }
            }

            $progressBar->advance();
        }

        if (!empty($batch)) {
            $this->persistBatch($batch);
        }

        $progressBar->finish();
        $output->writeln('');
    }

    /**
     * Build raw option data arrays for a given source field.
     * Format matches what SourceFieldOptionProcessor::persistMultiple() expects.
     *
     * @param array<\Gally\Catalog\Entity\LocalizedCatalog> $localizedCatalogs
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildRawOptionsForField(int $sourceFieldId, string $code, array $localizedCatalogs, GenerationConfig $config, bool $isLast = false): array
    {
        $sourceFieldIri = $this->routePrefix . '/source_fields/' . $sourceFieldId;

        // Returns entries like ['base' => 'Nike', 'suffix' => null] or ['base' => 'Nike', 'suffix' => ' 2']
        $optionEntries = $this->resolveOptionEntries($code, $config, $isLast);
        $options = [];

        foreach ($optionEntries as $position => $entry) {
            $base = $entry['base'];
            $suffix = $entry['suffix'];
            $label = $base . ($suffix ?? '');

            $optionCode = $this->sanitizeCode($label);

            $options[] = [
                'sourceField' => $sourceFieldIri,
                'code' => $optionCode,
                'defaultLabel' => $label,
                'position' => $position + 1,
                'labels' => $this->buildLabels($base, $localizedCatalogs, $suffix),
            ];
        }

        return $options;
    }

    /**
     * Build label entries only for locales that have a different translation.
     * Skips en_US (it's the default) and locales with no translation.
     *
     * @param array<\Gally\Catalog\Entity\LocalizedCatalog> $localizedCatalogs
     * @param string|null                                   $suffix            Numeric suffix appended after translation (e.g. " 2")
     *
     * @return array<int, array<string, string>>
     */
    private function buildLabels(string $defaultLabel, array $localizedCatalogs, ?string $suffix = null): array
    {
        $translations = $this->labelTranslator->getTranslations($defaultLabel, 'source_field_options', $suffix);

        $labels = [];
        foreach ($localizedCatalogs as $catalog) {
            $locale = $catalog->getLocale(); // e.g. "fr_FR"

            if (!\in_array($locale, LabelTranslator::SUPPORTED_LOCALES, true)) {
                continue;
            }

            if (!isset($translations[$locale])) {
                // No translation different from default → skip
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
     * Resolve option entries with base label and optional numeric suffix.
     * Suffix is null for predefined values, " 2", " 3"... for extended ones.
     *
     * @return array<int, array{base: string, suffix: string|null}>
     */
    private function resolveOptionEntries(string $code, GenerationConfig $config, bool $isLast = false): array
    {
        $targetCount = $this->getRealisticOptionsCount($config->getMaxOptionsPerField(), $isLast);

        foreach (self::OPTION_VALUES as $pattern => $baseValues) {
            if (str_contains($code, $pattern)) {
                return $this->fitEntriesToCount($baseValues, $targetCount);
            }
        }

        foreach ($this->fieldTypeProvider->getTemplatesForType(FieldTypeProvider::TYPE_SELECT) as $template) {
            if (str_contains($code, $template['code'])) {
                return $this->generateGenericEntries($code, $targetCount);
            }
        }

        return $this->generateGenericEntries($code, $targetCount);
    }

    /**
     * Fit predefined base values to target count.
     * Slices if too many, extends with numeric suffixes if not enough.
     *
     * @param array<int, string> $baseValues
     *
     * @return array<int, array{base: string, suffix: string|null}>
     */
    private function fitEntriesToCount(array $baseValues, int $targetCount): array
    {
        $entries = [];

        // First pass: predefined values without suffix
        foreach ($baseValues as $value) {
            if (\count($entries) >= $targetCount) {
                break;
            }
            $entries[] = ['base' => $value, 'suffix' => null];
        }

        // Second pass: extend with numeric suffixes
        $i = 2;
        while (\count($entries) < $targetCount) {
            foreach ($baseValues as $value) {
                $entries[] = ['base' => $value, 'suffix' => ' ' . $i];
                if (\count($entries) >= $targetCount) {
                    break;
                }
            }
            ++$i;
        }

        return $entries;
    }

    private function getRealisticOptionsCount(int $max, bool $forceMaxBucket = false): int
    {
        // If this is the last field and the 'max' bucket was never hit, force it
        if ($forceMaxBucket && 0 === $this->distributionTracker['max']) {
            ++$this->distributionTracker['max'];
            $lowerBound = (int) ($max * 0.8);

            return random_int(max(50, $lowerBound), $max);
        }

        $rand = random_int(1, 100);

        if ($rand <= 80) {
            ++$this->distributionTracker['small'];

            return random_int(2, min(20, $max));
        }

        if ($rand <= 95) {
            ++$this->distributionTracker['medium'];

            return random_int(20, min(50, $max));
        }

        if ($rand <= 99) {
            ++$this->distributionTracker['large'];
            $upperBound = (int) ($max * 0.8);

            return random_int(min(50, $max), max(50, $upperBound));
        }

        ++$this->distributionTracker['max'];
        $lowerBound = (int) ($max * 0.8);

        return random_int(max(50, $lowerBound), $max);
    }

    /**
     * Generate generic entries (no predefined values available).
     *
     * @return array<int, array{base: string, suffix: string|null}>
     */
    private function generateGenericEntries(string $code, int $count): array
    {
        $base = ucwords(str_replace('_', ' ', $code));
        $entries = [];

        for ($i = 1; $i <= $count; ++$i) {
            $entries[] = ['base' => $base, 'suffix' => ' ' . $i];
        }

        return $entries;
    }
}
