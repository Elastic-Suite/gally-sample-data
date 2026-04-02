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

use Gally\Catalog\Entity\Catalog;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Service\BatchPersister;
use Gally\SampleData\Service\CodeGenerator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates Catalog entities.
 */
class CatalogGenerator extends AbstractGenerator
{
    private const CATALOG_NAMES = [
        'European Store',
        'North American Store',
        'Asia-Pacific Store',
        'Latin American Store',
        'Middle East Store',
        'African Store',
        'Global Marketplace',
        'Premium Store',
        'Outlet Store',
        'Wholesale Store',
        'B2B Portal',
        'Retail Store',
        'Online Store',
        'Mobile Store',
        'Partner Store',
    ];

    private int $counter = 0;

    public function __construct(
        CodeGenerator $codeGenerator,
        private BatchPersister $batchPersister,
    ) {
        parent::__construct($codeGenerator);
    }

    protected function getEntityName(): string
    {
        return 'catalogs';
    }

    protected function getCount(GenerationConfig $config): int
    {
        return $config->getCatalogs();
    }

    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): Catalog {
        $name = $this->getNextCatalogName();
        $code = $this->codeGenerator->generateUniqueCode($this->sanitizeCode($name));

        $catalog = new Catalog();
        $catalog->setCode($code);
        $catalog->setName($name);

        ++$this->counter;
        $result->addCatalogs(1);

        return $catalog;
    }

    /**
     * @param array<Catalog> $batch
     */
    protected function persistBatch(array $batch): void
    {
        foreach ($batch as $catalog) {
            $this->batchPersister->persist($catalog);
        }
        $this->batchPersister->flush();
    }

    private function getNextCatalogName(): string
    {
        $index = $this->counter % \count(self::CATALOG_NAMES);
        $baseName = self::CATALOG_NAMES[$index];

        if ($this->counter >= \count(self::CATALOG_NAMES)) {
            $cycle = (int) floor($this->counter / \count(self::CATALOG_NAMES));
            $baseName .= ' ' . ($cycle + 1);
        }

        return $baseName;
    }
}
