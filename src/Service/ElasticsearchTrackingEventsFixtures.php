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
use Gally\Fixture\Service\EntityDataStreamsFixturesInterface;

class ElasticsearchTrackingEventsFixtures extends Fixture
{
    public function __construct(
        private ElasticsearchFixturesInterface $elasticsearchFixtures,
        private EntityDataStreamsFixturesInterface $entityDataStreamsFixtures,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->entityDataStreamsFixtures->createEntityElasticsearchDataStreams('tracking_event');
        $this->elasticsearchFixtures->loadFixturesDocumentFiles( // ); loadFixturesDocumentFilesForDataStream(
            [__DIR__ . '/../DataFixtures/elasticsearch/tracking_event_documents.json']
        );
    }
}
