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

use Doctrine\ORM\EntityManagerInterface;

/**
 * Persists entities in batches for optimal performance.
 * Handles flushing and clearing of the EntityManager to avoid memory issues.
 */
class BatchPersister
{
    private int $persistedCount = 0;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Persist a single entity.
     */
    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
        ++$this->persistedCount;
    }

    /**
     * Persist a batch of entities.
     *
     * @param array<object> $entities
     */
    public function persistBatch(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
            ++$this->persistedCount;
        }
    }

    /**
     * Flush changes to the database.
     */
    public function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * Clear the EntityManager to free memory.
     * This detaches all objects from the EntityManager.
     */
    public function clear(): void
    {
        $this->entityManager->clear();
    }

    /**
     * Flush and clear in one operation.
     * This is the recommended way to persist batches.
     */
    public function flushAndClear(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    /**
     * Get the number of entities persisted since the last reset.
     */
    public function getPersistedCount(): int
    {
        return $this->persistedCount;
    }

    /**
     * Reset the persisted count.
     */
    public function resetCount(): void
    {
        $this->persistedCount = 0;
    }
}
