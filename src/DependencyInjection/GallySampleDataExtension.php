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
/**
 * SF doc: https://symfony.com/doc/current/bundles/extension.html.
 */

namespace Gally\SampleData\DependencyInjection;

use Gally\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @codeCoverageIgnore
 */
class GallySampleDataExtension extends Extension
{
    /**
     * Allows to set config for others bundles.
     *
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig(
            'hautelook_alice',
            ['fixtures_path' => $this->fixturePaths()]
        );
    }

    /**
     * One entry per catalog folder under DataFixtures, plus its premium subfolder.
     *
     * Discovered rather than listed, so adding a catalog is a matter of dropping its folder in.
     * A glob cannot be put in the config directly: hautelook's EnvDirectoryLocator filters the
     * configured paths through file_exists() before handing them to the Finder, and then runs
     * the Finder with depth(0), so a pattern is discarded and a subdirectory is invisible.
     *
     * The premium folder has to be named exactly `premium`, because PremiumFilesLocator hides
     * it from an open-source install with a plain str_contains($file, '/premium/').
     *
     * @return string[]
     */
    private function fixturePaths(): array
    {
        $paths = [];

        foreach (glob(__DIR__ . '/../DataFixtures/*', \GLOB_ONLYDIR) ?: [] as $directory) {
            $catalog = basename($directory);
            $paths[] = 'DataFixtures/' . $catalog;

            if (is_dir($directory . '/premium')) {
                $paths[] = 'DataFixtures/' . $catalog . '/premium';
            }
        }

        sort($paths);

        return $paths;
    }

    /**
     * Allows to load services config and set bundle parameters in container.
     *
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../')
        );

        $loader->load('Resources/config/services.yaml');
    }
}
