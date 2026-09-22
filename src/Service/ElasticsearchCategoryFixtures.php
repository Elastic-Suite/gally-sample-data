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
use Gally\Fixture\Service\ElasticsearchFixtures;
use Gally\Fixture\Service\EntityIndicesFixturesInterface;
use Gally\SampleData\CatalogSelection;

class ElasticsearchCategoryFixtures extends Fixture
{
    public function __construct(
        private ElasticsearchFixtures $elasticsearchFixtures,
        private EntityIndicesFixturesInterface $entityIndicesFixtures,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // See ElasticsearchProductFixtures: one call covers every localized catalog.
        $this->entityIndicesFixtures->createEntityElasticsearchIndices('category');

        // See ElasticsearchProductFixtures: one call covers every localized catalog, and the
        // documents come from whichever catalog folders the selection loaded.
        $this->elasticsearchFixtures->loadFixturesDocumentFiles(
            CatalogSelection::documentFiles('categories_documents.json')
        );
    }
}
