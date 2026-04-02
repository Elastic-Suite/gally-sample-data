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

namespace Gally\SampleData\Provider;

use Doctrine\ORM\EntityManagerInterface;
use Gally\Metadata\Entity\Metadata;

/**
 * Provides metadata entities for sample data generation.
 */
class MetadataProvider
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Create and persist custom metadata entities.
     *
     * @param array<string> $entityNames Entity names to create metadata for
     *
     * @return array<Metadata>
     */
    public function createMetadata(array $entityNames): array
    {
        $metadataEntities = [];

        foreach ($entityNames as $entityName) {
            $metadata = new Metadata();
            $metadata->setEntity($entityName);
            $this->entityManager->persist($metadata);
            $metadataEntities[] = $metadata;
        }

        $this->entityManager->flush();

        return $metadataEntities;
    }
}
