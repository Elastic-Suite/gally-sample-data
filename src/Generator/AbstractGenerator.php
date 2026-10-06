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

use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Service\CodeGenerator;
use Random\Engine\Xoshiro256StarStar;
use Random\Randomizer;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base class for all entity generators.
 * Provides common utilities for generating test data.
 */
abstract class AbstractGenerator
{
    /** Seeded RNG for reproducible generation */
    protected Randomizer $randomizer;

    public function __construct(
        protected CodeGenerator $codeGenerator,
    ) {
    }

    /**
     * Generate all entities.
     */
    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        $this->setRandomizerCode($config->getSeed());
        $total = $this->getCount($config);
        $batchSize = $this->getBatchSize($config);
        $progressBar = $this->createProgressBar($output, $total, \sprintf('%d %s', $total, $this->getEntityName()));
        $progressBar->start();

        $batch = [];

        for ($index = 0; $index < $total; ++$index) {
            $batch[] = $this->generate($config, $result, $output, $index);
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

    abstract protected function getEntityName(): string;

    /**
     * Get the number of entities to generate from the config.
     */
    abstract protected function getCount(GenerationConfig $config): int;

    /**
     * Get the batch size for persistence.
     */
    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    /**
     * Generate a single entity or raw data array.
     */
    abstract protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): array|object;

    /**
     * Persist a batch of generated entities or data arrays.
     *
     * @param array<array|object> $batch
     */
    abstract protected function persistBatch(array $batch): void;

    /**
     * Sanitize a string to be code-friendly.
     * Converts to lowercase snake_case with only alphanumeric and underscore.
     */
    protected function sanitizeCode(string $value): string
    {
        $value = strtolower($value);
        $value = (string) preg_replace('/[^a-z0-9_]/', '_', $value);
        $value = (string) preg_replace('/_+/', '_', $value);

        return trim($value, '_');
    }

    protected function createProgressBar(OutputInterface $output, int $max, string $label): ProgressBar
    {
        $progressBar = new ProgressBar($output, $max);
        $progressBar->setMessage($label, 'label');
        $progressBar->setFormat(' - %label:-45s% [%bar%] %percent:3s%% %elapsed:12s% %peak_memory%');

        ProgressBar::setPlaceholderFormatterDefinition(
            'peak_memory',
            static fn () => \sprintf('%.1f MB', memory_get_peak_usage(true) / 1024 / 1024)
        );

        return $progressBar;
    }

    protected function setRandomizerCode(int $code): void
    {
        $this->randomizer = new Randomizer(new Xoshiro256StarStar($code));
    }
}
