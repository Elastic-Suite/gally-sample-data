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
use Gally\Catalog\Repository\LocalizedCatalogRepository;
use Gally\Fixture\Service\ElasticsearchFixturesInterface;
use Gally\Fixture\Service\EntityDataStreamsFixturesInterface;
use Gally\Tracker\Service\SessionTransformProvisioner;

class ElasticsearchTrackingEventsFixtures extends Fixture
{
    public function __construct(
        private ElasticsearchFixturesInterface $elasticsearchFixtures,
        private EntityDataStreamsFixturesInterface $entityDataStreamsFixtures,
        private LocalizedCatalogRepository $localizedCatalogRepository,
        private SessionTransformProvisioner $sessionTransformProvisioner,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->entityDataStreamsFixtures->createEntityElasticsearchDataStreams('tracking_event');
        $this->elasticsearchFixtures->loadFixturesDocumentFiles(
            [__DIR__ . '/../DataFixtures/elasticsearch/tracking_event_documents.json']
        );

        // Bypasses TrackingEventHandler, so its automated tracking_session provisioning never
        // runs here -- do it explicitly instead.
        foreach ($this->localizedCatalogRepository->findAll() as $localizedCatalog) {
            $this->sessionTransformProvisioner->createOrUpdate($localizedCatalog);
        }
    }
}
