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

/**
 * Generates unique codes for entities.
 * Uses an in-memory HashSet to track used codes and avoid collisions.
 */
class CodeGenerator // TODO TABNINE: pourquoi cette classe est dans service et pas provider ??
{
    /** @var array<string, bool> */
    private array $usedCodes = [];

    private int $counter = 0;

    /**
     * Generate a unique code with the given prefix.
     *
     * @param string $prefix    The prefix for the code (will be sanitized)
     * @param int    $maxLength Maximum length of the generated code
     *
     * @throws \RuntimeException If unable to generate a unique code after 100 attempts
     */
    public function generateUniqueCode(string $prefix, int $maxLength = 255): string
    {
        $prefix = $this->sanitizePrefix($prefix);
        $attempts = 0;

        do {
            if ($attempts > 100) {
                throw new \RuntimeException(\sprintf('Unable to generate unique code with prefix "%s" after 100 attempts', $prefix));
            }

            $code = $this->generateCode($prefix, $maxLength);
            ++$attempts;
        } while ($this->isCodeUsed($code));

        $this->markCodeAsUsed($code);

        return $code;
    }

    /**
     * Generate a simple sequential code (for testing or simple cases).
     */
    public function generateSequentialCode(string $prefix): string
    {
        $prefix = $this->sanitizePrefix($prefix);
        $code = \sprintf('%s_%d', $prefix, $this->counter);
        ++$this->counter;

        $this->markCodeAsUsed($code);

        return $code;
    }

    /**
     * Check if a code is already used.
     */
    public function isCodeUsed(string $code): bool
    {
        return isset($this->usedCodes[$code]);
    }

    /**
     * Mark a code as used (useful when loading existing data).
     */
    public function markCodeAsUsed(string $code): void
    {
        $this->usedCodes[$code] = true;
    }

    /**
     * Reset the internal state (used codes and counter).
     */
    public function reset(): void
    {
        $this->usedCodes = [];
        $this->counter = 0;
    }

    /**
     * Get the number of codes generated.
     */
    public function getGeneratedCount(): int
    {
        return \count($this->usedCodes);
    }

    /**
     * Generate a code with the given prefix.
     * Pattern: {prefix}_{counter} for simplicity and predictability.
     */
    private function generateCode(string $prefix, int $maxLength): string
    {
        $code = \sprintf('%s_%d', $prefix, $this->counter);
        ++$this->counter;

        // Ensure we don't exceed max length
        if (\strlen($code) > $maxLength) {
            $code = substr($code, 0, $maxLength);
        }

        return $code;
    }

    /**
     * Sanitize a prefix to make it code-friendly.
     * Converts to lowercase snake_case with only alphanumeric and underscore.
     */
    private function sanitizePrefix(string $prefix): string
    {
        // Convert to lowercase
        $prefix = strtolower($prefix);

        // Replace spaces and special chars with underscore
        $prefix = (string) preg_replace('/[^a-z0-9_]/', '_', $prefix);

        // Remove consecutive underscores
        $prefix = (string) preg_replace('/_+/', '_', $prefix);

        // Trim underscores from start and end
        $prefix = trim($prefix, '_');

        // Ensure we have something
        if (empty($prefix)) {
            $prefix = 'item';
        }

        return $prefix;
    }
}
