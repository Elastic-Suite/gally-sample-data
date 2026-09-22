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
use Gally\SampleData\CatalogSelection;

class ElasticsearchCmsPageFixtures extends Fixture
{
    public function __construct(
        private ElasticsearchFixturesInterface $elasticsearchFixtures,
        private EntityIndicesFixturesInterface $entityIndicesFixtures,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->entityIndicesFixtures->createEntityElasticsearchIndices('cms_page');

        // A catalog folder without a cms_page document file is skipped rather than reported:
        // the Magento demo the other catalogs are generated from ships no editorial content.
        $this->elasticsearchFixtures->loadFixturesDocumentFiles(
            CatalogSelection::documentFiles('cms_page_documents.json')
        );
    }
}
