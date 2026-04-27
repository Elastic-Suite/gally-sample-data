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

/**
 * Provides real locales with their associated currencies.
 */
class LocaleProvider
{
    /** @var array<int, array{code: string, name: string, currency: string}>|null */
    private ?array $locales = null;

    /** @var array<string, array{code: string, name: string, currency: string}>|null */
    private ?array $byCode = null;

    /**
     * Get all available locales.
     *
     * @return array<int, array{code: string, name: string, currency: string}>
     */
    public function getAllLocales(): array
    {
        if (null === $this->locales) {
            $this->buildLocales();
        }

        return $this->locales;
    }

    /**
     * Get all locales indexed by their code.
     *
     * @return array<string, array{code: string, name: string, currency: string}>
     */
    public function getAllLocalesByCode(): array
    {
        if (null === $this->byCode) {
            $this->buildLocales();
        }

        return $this->byCode;
    }

    private function buildLocales(): void
    {
        $this->locales = [];
        $this->byCode = [];

        foreach (\ResourceBundle::getLocales('') as $code) {
            if (!str_contains($code, '_') || substr_count($code, '_') > 1) {
                continue;
            }

            try {
                $formatter = new \NumberFormatter($code, \NumberFormatter::CURRENCY);
                $currency = $formatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE);
                $name = \Locale::getDisplayName($code, 'en');

                if ($currency && $name) {
                    $localeData = [
                        'code' => $code,
                        'name' => $name,
                        'currency' => $currency,
                    ];

                    $this->locales[] = $localeData;
                    $this->byCode[$code] = $localeData;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    /**
     * Returns the least-used locale that is not in the excluded list.
     * Locales never used are picked first, with shuffle among ex-aequo.
     *
     * @param array<string> $usedGlobally  all locale codes used across all catalogs (with duplicates for counting)
     * @param array<string> $excludedCodes locale codes already used in the current catalog
     */
    public function getLeastUsedLocale(array $usedGlobally, array $excludedCodes): ?string
    {
        $byCode = $this->getAllLocalesByCode();

        $candidates = array_filter(
            array_keys($byCode),
            fn (string $code) => !\in_array($code, $excludedCodes, true)
        );

        if (empty($candidates)) {
            return null;
        }

        $usageCounts = array_count_values($usedGlobally);

        usort(
            $candidates,
            fn (string $a, string $b) => ($usageCounts[$a] ?? 0) <=> ($usageCounts[$b] ?? 0)
        );

        $minUsage = $usageCounts[$candidates[0]] ?? 0;
        $minGroup = array_values(array_filter($candidates, fn ($c) => ($usageCounts[$c] ?? 0) === $minUsage));
        shuffle($minGroup);

        return $minGroup[0];
    }

    /**
     * Get locale by code.
     *
     * @return array{code: string, name: string, currency: string}|null
     */
    public function getLocaleByCode(string $code): ?array
    {
        $byCode = $this->getAllLocalesByCode();

        return $byCode[$code] ?? null;
    }
}
