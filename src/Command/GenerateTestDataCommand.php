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

namespace Gally\SampleData\Command;

use Gally\Index\Repository\Index\IndexRepositoryInterface;
use Gally\SampleData\Generator\CatalogGenerator;
use Gally\SampleData\Generator\CategoryGenerator;
use Gally\SampleData\Generator\LocalizedCatalogGenerator;
use Gally\SampleData\Generator\ProductGenerator;
use Gally\SampleData\Generator\SourceFieldGenerator;
use Gally\SampleData\Generator\SourceFieldOptionGenerator;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Provider\MetadataProvider;
use Gally\SampleData\Provider\UserProvider;
use Gally\SampleData\Service\DatabaseResetService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'gally:sample-data:generate')]
class GenerateTestDataCommand extends Command
{
    public function __construct(
        private CatalogGenerator $catalogGenerator,
        private LocalizedCatalogGenerator $localizedCatalogGenerator,
        private SourceFieldGenerator $sourceFieldGenerator,
        private SourceFieldOptionGenerator $sourceFieldOptionGenerator,
        private CategoryGenerator $categoryGenerator,
        private ProductGenerator $productGenerator,
        private UserProvider $userProvider,
        private MetadataProvider $metadataProvider,
        private IndexRepositoryInterface $indexRepository,
        private DatabaseResetService $databaseResetService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('preset', 'p', InputOption::VALUE_REQUIRED, 'Use a preset configuration (small, medium, large, enterprise)')
            ->addOption('catalogs', null, InputOption::VALUE_REQUIRED, 'Number of catalogs to generate')
            ->addOption('locales-per-catalog', null, InputOption::VALUE_REQUIRED, 'Number of locales per catalog (average)')
            ->addOption('source-fields', null, InputOption::VALUE_REQUIRED, 'Number of source fields to generate')
            ->addOption('categories', null, InputOption::VALUE_REQUIRED, 'Number of categories to generate')
            ->addOption('products', null, InputOption::VALUE_REQUIRED, 'Number of products to generate')
            ->addOption('batch-size', null, InputOption::VALUE_REQUIRED, 'Batch size for database operations', 1000)
            ->addOption('max-options-per-field', null, InputOption::VALUE_REQUIRED, 'Maximum options per select field')
            ->addOption('max-category-depth', null, InputOption::VALUE_REQUIRED, 'Maximum depth of category tree')
            ->addOption('extra-metadata', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Additional metadata entities to create (e.g., --extra-metadata=brand)')
            ->addOption('variant-ratio', null, InputOption::VALUE_REQUIRED, 'Percentage of products that will be configurable (with color/size variants)', 20)
            ->addOption('filterable-percentage', null, InputOption::VALUE_REQUIRED, 'Percentage of source fields that will be filterable', 10)
            ->addOption('searchable-percentage', null, InputOption::VALUE_REQUIRED, 'Percentage of source fields that will be searchable', 100)
            ->addOption('seed', null, InputOption::VALUE_REQUIRED, 'Seed for random generation (for reproducibility)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        ini_set('memory_limit', '2G');

        $config = $this->buildConfiguration($input, $io);
        if (null === $config) {
            return Command::INVALID;
        }

        $extraMetadata = $input->getOption('extra-metadata') ?: [];

        $this->displayConfiguration($io, $config, $extraMetadata);

        if ($input->isInteractive() && !$io->confirm('Start generation?', true)) {
            $io->info('Generation cancelled.');

            return Command::SUCCESS;
        }

        $result = new GenerationResult();

        try {
            $io->section('Initialization');
            $this->databaseResetService->resetDatabase();
            $this->indexRepository->delete('gally*');
            $this->userProvider->createDefaultUsers();
            $io->text('- Database recreated, indices cleared, and users created');
            $io->newLine();

            if (!empty($extraMetadata)) {
                $this->metadataProvider->createMetadata($extraMetadata);
            }

            $io->section('Generating Structure');
            $this->catalogGenerator->generateAll($config, $result, $output);
            $this->localizedCatalogGenerator->generateAll($config, $result, $output);
            $this->sourceFieldGenerator->generateAll($config, $result, $output);
            $this->sourceFieldOptionGenerator->generateAll($config, $result, $output);

            $io->newLine();

            $io->section('Generating Catalog Data');
            $this->categoryGenerator->generateAll($config, $result, $output);
            $this->productGenerator->generateAll($config, $result, $output);

            $io->newLine();

            $result->markComplete();
            $this->displayResults($io, $result);
            $io->success('Test data generation completed successfully!');

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $io->error(\sprintf('Generation failed: %s', $exception->getMessage()));
            if ($output->isVerbose()) {
                $io->block($exception->getTraceAsString(), 'ERROR', 'fg=white;bg=red', ' ', true);
            }

            return Command::FAILURE;
        }
    }

    private function buildConfiguration(InputInterface $input, SymfonyStyle $io): ?GenerationConfig
    {
        $preset = $input->getOption('preset');

        if ($preset) {
            try {
                $config = GenerationConfig::fromPreset($preset);
            } catch (\InvalidArgumentException $exception) {
                $io->error($exception->getMessage());

                return null;
            }
        } else {
            $config = new GenerationConfig();
        }

        // CLI options override preset values when explicitly provided.
        // The null check prevents a missing option from resetting a preset value to 0.
        if ($input->getOption('catalogs')) {
            $config->setCatalogs((int) $input->getOption('catalogs'));
        }
        if ($input->getOption('locales-per-catalog')) {
            $config->setLocalesPerCatalog((int) $input->getOption('locales-per-catalog'));
        }
        if ($input->getOption('source-fields')) {
            $config->setSourceFields((int) $input->getOption('source-fields'));
        }
        if ($input->getOption('categories')) {
            $config->setCategories((int) $input->getOption('categories'));
        }
        if ($input->getOption('products')) {
            $config->setProducts((int) $input->getOption('products'));
        }
        if ($input->getOption('batch-size')) {
            $config->setBatchSize((int) $input->getOption('batch-size'));
        }
        if ($input->getOption('max-options-per-field')) {
            $config->setMaxOptionsPerField((int) $input->getOption('max-options-per-field'));
        }
        if ($input->getOption('max-category-depth')) {
            $config->setMaxCategoryDepth((int) $input->getOption('max-category-depth'));
        }
        if ($input->getOption('seed')) {
            $config->setSeed((int) $input->getOption('seed'));
        }
        if (null !== $input->getOption('variant-ratio')) {
            $config->setConfigurableProductPercentage((int) $input->getOption('variant-ratio'));
        }
        if (null !== $input->getOption('filterable-percentage')) {
            $config->setFilterablePercentage((int) $input->getOption('filterable-percentage'));
        }
        if (null !== $input->getOption('searchable-percentage')) {
            $config->setSearchablePercentage((int) $input->getOption('searchable-percentage'));
        }

        return $config;
    }

    private function displayConfiguration(SymfonyStyle $io, GenerationConfig $config, array $extraMetadata = []): void
    {
        $io->title('Gally Test Data Generator');

        $visibleMetadata = ['product', 'category'];
        $totalMetadata = \count($visibleMetadata) + \count($extraMetadata);
        $metadataDisplay = $totalMetadata . ' (' . implode(', ', $visibleMetadata);
        if (!empty($extraMetadata)) {
            $metadataDisplay .= ', ' . implode(', ', $extraMetadata);
        }
        $metadataDisplay .= ')';

        $io->section('Configuration');
        $io->table(
            ['Parameter', 'Value'],
            [
                ['Catalogs', $config->getCatalogs()],
                ['Locales per catalog', $config->getLocalesPerCatalog()],
                ['Metadata entities', $metadataDisplay],
                ['Source Fields (product)', $config->getSourceFields()],
                ['Source Fields (category)', '10-20 (random)'],
                ['Filterable source fields', $config->getFilterablePercentage() . '%'],
                ['Searchable source fields', $config->getSearchablePercentage() . '%'],
                ['Categories', $config->getCategories() ?: 'Not configured'],
                ['Products', $config->getProducts() ?: 'Not configured'],
                ['Variant ratio', $config->getConfigurableProductPercentage() . '%'],
                ['Batch size', $config->getBatchSize()],
                ['Seed', $config->getSeed() ?: 'Random'],
            ]
        );
    }

    private function displayResults(SymfonyStyle $io, GenerationResult $result): void
    {
        $io->section('Results');

        $io->table(
            ['Entity Type', 'Count'],
            [
                ['Catalogs', $result->getCatalogsGenerated()],
                ['Localized Catalogs', $result->getLocalizedCatalogsGenerated()],
                ['Source Fields', $result->getSourceFieldsGenerated()],
                ['Source Field Options', $result->getSourceFieldOptionsGenerated()],
                ['Categories', $result->getCategoriesGenerated() ?: 'N/A'],
                ['Products', $result->getProductsGenerated() ?: 'N/A'],
            ]
        );

        $io->table(
            ['Metric', 'Value'],
            [
                ['Execution time', $result->getFormattedExecutionTime()],
                ['Peak memory', \sprintf('%s MB', $result->getPeakMemoryMB())],
                ['Entities/second', $result->getExecutionTimeSeconds() > 0 ? \sprintf('%.0f', $result->getTotalEntitiesGenerated() / $result->getExecutionTimeSeconds()) : 'N/A'],
                ['Products/second', $result->getExecutionTimeSeconds() > 0 ? \sprintf('%.0f', ($result->getProductsGenerated() ?: 0) / $result->getExecutionTimeSeconds()) : 'N/A'],
            ]
        );
    }
}
