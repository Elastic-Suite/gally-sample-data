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
            ['fixtures_path' => [
                'DataFixtures',
                'DataFixtures/premium',
            ],
            ]);
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
