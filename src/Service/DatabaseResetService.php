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

namespace Gally\SampleData\Service;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\FilesystemMigrationsRepository;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorage;
use Doctrine\Migrations\MigratorConfiguration;
use Doctrine\Migrations\Version\SortedMigrationPlanCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Service for resetting database schema and running migrations.
 */
class DatabaseResetService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private DependencyFactory $dependencyFactory,
    ) {
    }

    /**
     * Drop database schema and recreate it via migrations.
     * Uses the same robust approach as tests.
     */
    public function resetDatabase(): void
    {
        // Drop database schema
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropDatabase();

        // Recreate database schema with migrations
        $migratorConfiguration = (new MigratorConfiguration())
            ->setDryRun(false)
            ->setTimeAllQueries(false)
            ->setAllOrNothing(true);

        $migrationsRepository = new FilesystemMigrationsRepository(
            $this->dependencyFactory->getConfiguration()->getMigrationClasses(),
            $this->dependencyFactory->getConfiguration()->getMigrationDirectories(),
            $this->dependencyFactory->getMigrationsFinder(),
            $this->dependencyFactory->getMigrationFactory(),
        );

        $planCalculator = new SortedMigrationPlanCalculator(
            $migrationsRepository,
            $this->dependencyFactory->getMetadataStorage(),
            $this->dependencyFactory->getVersionComparator(),
        );

        $version = $this->dependencyFactory->getVersionAliasResolver()->resolveVersionAlias('latest');
        $plan = $planCalculator->getPlanUntilVersion($version);

        // Create metadata storage and execute migrations
        $metadataStorage = new TableMetadataStorage(
            $this->dependencyFactory->getConnection(),
            $this->dependencyFactory->getVersionComparator(),
            $this->dependencyFactory->getConfiguration()->getMetadataStorageConfiguration(),
            $this->dependencyFactory->getMigrationRepository(),
        );
        $metadataStorage->ensureInitialized();
        $this->dependencyFactory->getMigrator()->migrate($plan, $migratorConfiguration);

        $this->entityManager->clear();
    }
}
