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

namespace Gally\SampleData;

/**
 * Which catalog folders under DataFixtures/ take part in a load.
 *
 * Every folder loads by default. Set GALLY_SAMPLE_DATA_CATALOGS to a comma separated list of
 * folder names to load a subset: the e2e suite asks for `default`, so the admin grids hold the
 * rows the tests were written against whatever demo catalogs ship alongside them.
 *
 * `common` always loads. It carries the cms_page metadata, the users and the source fields every
 * catalog shares, so a selection without it would build an instance nobody can log into.
 *
 * The variable is read while the DI container compiles, so its value is baked into the cached
 * container. Run `bin/console cache:clear` after changing it, or the load silently keeps using
 * the previous selection.
 */
final class CatalogSelection
{
    public const ENV_VAR = 'GALLY_SAMPLE_DATA_CATALOGS';

    /** Always loaded: holds what every catalog needs to stand up on its own. */
    public const COMMON = 'common';

    /**
     * Folder names taking part in this load, sorted.
     *
     * @return string[]
     */
    public static function folders(): array
    {
        $available = self::available();
        $requested = self::requested();

        if (null === $requested) {
            return $available;
        }

        $unknown = array_diff($requested, $available);
        if ([] !== $unknown) {
            throw new \RuntimeException(sprintf(
                'Unknown sample data catalog "%s" in %s. Available: %s.',
                implode('", "', $unknown),
                self::ENV_VAR,
                implode(', ', $available),
            ));
        }

        $selected = array_merge([self::COMMON], $requested);

        return array_values(array_intersect($available, $selected));
    }

    /** Absolute path of one catalog folder. */
    public static function path(string $folder): string
    {
        return self::fixturesDir() . '/' . $folder;
    }

    /**
     * Absolute paths of $filename under every selected catalog's elasticsearch/ folder.
     *
     * A catalog that carries no document of this entity is skipped rather than reported: the
     * generated catalogs legitimately have no cms_page file, and `common` has no documents at
     * all. This replaces the four hardcoded arrays that used to need a new line per catalog.
     *
     * @return string[]
     */
    public static function documentFiles(string $filename): array
    {
        $files = [];

        foreach (self::folders() as $folder) {
            $file = self::path($folder) . '/elasticsearch/' . $filename;
            if (is_file($file)) {
                $files[] = $file;
            }
        }

        return $files;
    }

    /**
     * Every catalog folder on disk, sorted.
     *
     * @return string[]
     */
    private static function available(): array
    {
        $folders = [];

        foreach (glob(self::fixturesDir() . '/*', \GLOB_ONLYDIR) ?: [] as $directory) {
            $folders[] = basename($directory);
        }

        sort($folders);

        return $folders;
    }

    /**
     * @return string[]|null null means "nothing was asked for", so load everything
     */
    private static function requested(): ?array
    {
        $raw = $_ENV[self::ENV_VAR] ?? $_SERVER[self::ENV_VAR] ?? getenv(self::ENV_VAR);

        if (!\is_string($raw) || '' === trim($raw)) {
            return null;
        }

        return array_values(array_unique(array_filter(array_map('trim', explode(',', $raw)), 'strlen')));
    }

    private static function fixturesDir(): string
    {
        return __DIR__ . '/DataFixtures';
    }
}
