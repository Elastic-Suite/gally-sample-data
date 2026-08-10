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

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Translates labels for source fields and options using Symfony's translator.
 * Supports en_US, fr_FR, es_ES, de_DE only.
 * Caches results in memory to avoid repeated translator calls.
 */
class LabelTranslator
{
    /** Locales supported for translation. en_US is the default/source language. */
    public const SUPPORTED_LOCALES = ['en_US', 'fr_FR', 'es_ES', 'de_DE'];

    /**
     * In-memory cache: domain → locale → label → translation.
     *
     * @var array<string, array<string, array<string, string>>>
     */
    private array $cache = [];

    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * Returns translations for all supported locales that differ from the default label.
     * The suffix (e.g. " 2") is appended AFTER translation of the base label.
     *
     * @return array<string, string> locale => translated label
     */
    public function getTranslations(string $defaultLabel, string $domain, ?string $suffix = null): array
    {
        $result = [];

        foreach (self::SUPPORTED_LOCALES as $locale) {
            // en_US is the source language — no translation needed unless there's a suffix
            if ('en_US' === $locale) {
                if (null !== $suffix) {
                    $result[$locale] = $defaultLabel . $suffix;
                }
                continue;
            }

            $translatedBase = $this->translateBase($defaultLabel, $domain, $locale);

            // No translation found or same as default → skip
            if (null === $translatedBase || $translatedBase === $defaultLabel) {
                continue;
            }

            $result[$locale] = $translatedBase . ($suffix ?? '');
        }

        return $result;
    }

    /**
     * Translate the base label (without suffix) for a given locale.
     * Returns null if no translation exists (key not found → Symfony returns the key itself).
     */
    private function translateBase(string $defaultLabel, string $domain, string $locale): ?string
    {
        if (isset($this->cache[$domain][$locale][$defaultLabel])) {
            return $this->cache[$domain][$locale][$defaultLabel];
        }

        $key = $this->labelToKey($domain, $defaultLabel);
        $translated = $this->translator->trans($key, [], $domain, $locale);

        // Symfony returns the key itself when no translation is found
        if ($translated === $key) {
            $this->cache[$domain][$locale][$defaultLabel] = null;

            return null;
        }

        $this->cache[$domain][$locale][$defaultLabel] = $translated;

        return $translated;
    }

    /**
     * Convert a human label to its translation key.
     * e.g. "Brand" in domain "source_fields" → "gally.source_field.brand"
     * e.g. "Red"   in domain "source_field_options" → "gally.source_field_option.red".
     */
    private function labelToKey(string $domain, string $label): string
    {
        $slug = strtolower(str_replace([' ', '-', '/'], '_', $label));

        return match ($domain) {
            'source_fields' => 'gally.source_field.' . $slug,
            'source_field_options' => 'gally.source_field_option.' . $slug,
            default => $slug,
        };
    }
}
