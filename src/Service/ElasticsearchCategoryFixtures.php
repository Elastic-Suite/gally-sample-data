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

class ElasticsearchCategoryFixtures extends Fixture
{
    public function __construct(
        private ElasticsearchFixtures $elasticsearchFixtures,
        private EntityIndicesFixturesInterface $entityIndicesFixtures,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->entityIndicesFixtures->createEntityElasticsearchIndices('category');
        $this->elasticsearchFixtures->loadFixturesDocumentFiles([__DIR__ . '/../DataFixtures/elasticsearch/categories_documents.json']);
    }
}
