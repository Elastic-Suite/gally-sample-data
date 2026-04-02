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
use Gally\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Provides default users for sample data generation.
 */
class UserProvider
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * Create and persist default users (admin and contributor).
     *
     * @return array<User>
     */
    public function createDefaultUsers(): array
    {
        $users = [];

        // Create admin user
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setFirstName('John');
        $admin->setLastName('Doe');
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'apassword');
        $admin->setPassword($hashedPassword);
        $this->entityManager->persist($admin);
        $users[] = $admin;

        // Create contributor user
        $contributor = new User();
        $contributor->setEmail('contributor@example.com');
        $contributor->setFirstName('Jane');
        $contributor->setLastName('Doe');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword($contributor, 'apassword');
        $contributor->setPassword($hashedPassword);
        $this->entityManager->persist($contributor);
        $users[] = $contributor;

        $this->entityManager->flush();

        return $users;
    }
}
