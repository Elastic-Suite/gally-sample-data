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

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Gally\Fixture\Service\ElasticsearchFixturesInterface;
use Gally\Fixture\Service\EntityIndicesFixturesInterface;

class ElasticsearchProductFixtures extends Fixture
{
    public function __construct(
        private ElasticsearchFixturesInterface $elasticsearchFixtures,
        private EntityIndicesFixturesInterface $entityIndicesFixtures,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Indices are created for every localized catalog present in the database, so this
        // single call covers every catalog whose localized_catalogs.yaml has just been loaded.
        // A second fixture service calling it again would create a second physical index and
        // re-point the alias, orphaning whatever the first one had already indexed.
        $this->entityIndicesFixtures->createEntityElasticsearchIndices('product');

        // One line per catalog. This list is the enable switch: the storefront takes the first
        // catalog the API returns, so which catalogs carry documents is a decision.
        $this->elasticsearchFixtures->loadFixturesDocumentFiles([
            __DIR__ . '/../DataFixtures/default/elasticsearch/product_documents.json',
            __DIR__ . '/../DataFixtures/00_toolbox/elasticsearch/product_documents.json',
            __DIR__ . '/../DataFixtures/01_fashion/elasticsearch/product_documents.json',
            __DIR__ . '/../DataFixtures/02_papershop/elasticsearch/product_documents.json',
        ]);
    }
}
