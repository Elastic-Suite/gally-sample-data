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
        // Called once, from here only. Unlike the index equivalents, this drops the data stream,
        // its ISM policy and its index template before recreating them, so a second service
        // calling it again would wipe whatever the first had already indexed. It iterates every
        // localized catalog, so every catalog folder's data streams come from this one call.
        $this->entityDataStreamsFixtures->createEntityElasticsearchDataStreams('tracking_event');

        // One line per catalog folder. A data stream is written with op_type `create`, not
        // `index`, so a duplicate event id inside one stream is a 409 that fails the whole load
        // rather than silently overwriting the way the product documents would.
        $this->elasticsearchFixtures->loadFixturesDocumentFiles([
            __DIR__ . '/../DataFixtures/default/elasticsearch/tracking_event_documents.json',
            __DIR__ . '/../DataFixtures/00_toolbox/elasticsearch/tracking_event_documents.json',
            __DIR__ . '/../DataFixtures/01_fashion/elasticsearch/tracking_event_documents.json',
            __DIR__ . '/../DataFixtures/02_papershop/elasticsearch/tracking_event_documents.json',
        ]);
    }
}
