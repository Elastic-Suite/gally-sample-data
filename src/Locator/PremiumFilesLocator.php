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

namespace Gally\SampleData\Locator;

use Gally\Bundle\State\ExtraBundleProvider;
use Gally\SampleData\GallySampleDataBundle;
use Hautelook\AliceBundle\FixtureLocatorInterface;
use Nelmio\Alice\IsAServiceTrait;

final class PremiumFilesLocator implements FixtureLocatorInterface
{
    use IsAServiceTrait;

    public function __construct(
        private FixtureLocatorInterface $decoratedFixtureLocator,
        private ExtraBundleProvider $extraBundleProvider,
    ) {
    }

    public function locateFiles(array $bundles, string $environment): array
    {
        $files = $this->decoratedFixtureLocator->locateFiles($bundles, $environment);
        // If premium bundles are not installed, we do not run premium fixtures
        if (empty($this->getExtraBundlesCleaned())) {
            $files = array_filter($files, [$this, 'filterPremiumFixtures']);
        }

        return $files;
    }

    protected function getExtraBundlesCleaned(): array
    {
        $sampleDataBundleName = explode('\\', GallySampleDataBundle::class);
        $sampleDataBundleName = array_pop($sampleDataBundleName);

        $extraBundles = $this->extraBundleProvider->get();
        $sampleDataBundleKey = array_search($sampleDataBundleName, array_column($extraBundles, 'name'), true);
        if (false !== $sampleDataBundleKey) {
            unset($extraBundles[$sampleDataBundleKey]);
        }

        return $extraBundles;
    }

    private function filterPremiumFixtures(string $file): bool
    {
        return !str_contains($file, '/premium/');
    }
}
