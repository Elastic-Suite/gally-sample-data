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

namespace Gally\SampleData\Generator;

use Gally\Catalog\Entity\Catalog;
use Gally\Catalog\Entity\LocalizedCatalog;
use Gally\Catalog\Repository\CatalogRepository;
use Gally\SampleData\Model\GenerationConfig;
use Gally\SampleData\Model\GenerationResult;
use Gally\SampleData\Provider\LocaleProvider;
use Gally\SampleData\Service\BatchPersister;
use Gally\SampleData\Service\CodeGenerator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates LocalizedCatalog entities for a given Catalog.
 * Ensures locale diversity across catalogs and guarantees at least one fr_FR overall.
 */
class LocalizedCatalogGenerator extends AbstractGenerator
{
    /**
     * Locales that are prioritized when filling slots beyond en_US.
     * Order matters: first entries are picked first.
     */
    private const PRIORITY_LOCALES = ['es_ES', 'de_DE'];

    /** Probability (0-100) that a catalog gets en_US. */
    private const EN_US_PROBABILITY = 90;

    /** Ensure that we have a fr locale on the first catalog. */
    private static bool $frFrAdded = false;

    /** Ensure that we have a en locale on almost every catalog. */
    private static bool $enUSTried = false;

    private static array $allUsedLocale = [];

    private static array $catalogUsedLocale = [];

    private ?Catalog $currentCatalog = null;

    private ?int $currentCatalogLocaleCount = null;

    private string $entityName = 'localized catalogs';

    public function __construct(
        CodeGenerator $codeGenerator,
        private LocaleProvider $localeProvider,
        private BatchPersister $batchPersister,
        private CatalogRepository $catalogRepository,
    ) {
        parent::__construct($codeGenerator);
    }

    public function generateAll(GenerationConfig $config, GenerationResult $result, OutputInterface $output): void
    {
        $catalogs = $this->catalogRepository->findAll();

        foreach ($catalogs as $catalog) {
            $this->setCurrentCatalog($catalog);
            self::$catalogUsedLocale = [];
            parent::generateAll($config, $result, $output);
        }
    }

    protected function getEntityName(): string
    {
        return $this->entityName;
    }

    protected function getCount(GenerationConfig $config): int
    {
        if (null === $this->currentCatalogLocaleCount) {
            $this->currentCatalogLocaleCount = max(1, $config->getLocalesPerCatalog()); // + random_int(-1, 1));
        }

        return $this->currentCatalogLocaleCount;
    }

    protected function getBatchSize(GenerationConfig $config): int
    {
        return $config->getBatchSize();
    }

    protected function generate(
        GenerationConfig $config,
        GenerationResult $result,
        OutputInterface $output,
        int $index,
    ): LocalizedCatalog {
        $catalog = $this->currentCatalog;
        $localeData = $this->pickNewLocale();

        $localizedCatalog = new LocalizedCatalog();
        $localeCode = str_replace('_', '', strtolower($localeData['code']));
        $localizedCatalog->setCode(\sprintf('%s_%s', $catalog->getCode(), $localeCode));
        $localizedCatalog->setName(\sprintf('%s - %s', $catalog->getName(), $localeData['name']));
        $localizedCatalog->setLocale($localeData['code']);
        $localizedCatalog->setCurrency($localeData['currency']);
        $localizedCatalog->setCatalog($catalog);

        $result->addLocalizedCatalogs(1);

        return $localizedCatalog;
    }

    /**
     * @param array<LocalizedCatalog> $batch
     */
    protected function persistBatch(array $batch): void
    {
        foreach ($batch as $localizedCatalog) {
            $this->batchPersister->persist($localizedCatalog);
        }
        $this->batchPersister->flush();
    }

    private function setCurrentCatalog(Catalog $catalog): void
    {
        $this->currentCatalog = $catalog;
        $this->currentCatalogLocaleCount = null;
        $this->entityName = 'localized catalogs for ' . $catalog->getName();
        self::$enUSTried = false;
    }

    /**
     * Return locale data.
     *
     * Rules:
     * - en_US is included with EN_US_PROBABILITY% chance (always if only 1 slot)
     * - fr_FR is forced on the last catalog if not yet assigned anywhere
     * - es_ES and de_DE are prioritized for remaining slots
     * - Locales used less often by other catalogs are preferred (diversity)
     * - No locale is repeated within the same catalog
     *
     * @return array{code: string, name: string, currency: string}
     */
    private function pickNewLocale(): array
    {
        // fr_FR guarantee
        if (!self::$frFrAdded && !\in_array('fr_FR', self::$catalogUsedLocale, true)) {
            return $this->registerLocale('fr_FR');
        }

        // en_US on most catalogs
        if (!\in_array('en_US', self::$catalogUsedLocale, true) && !self::$enUSTried) {
            self::$enUSTried = true;
            if (random_int(1, 100) <= self::EN_US_PROBABILITY) {
                return $this->registerLocale('en_US');
            }
        }

        // Priority locales
        foreach (self::PRIORITY_LOCALES as $code) {
            if (!\in_array($code, self::$catalogUsedLocale, true)) {
                return $this->registerLocale($code);
            }
        }

        // Least used globally
        $code = $this->localeProvider->getLeastUsedLocale(self::$allUsedLocale, self::$catalogUsedLocale);
        if (null === $code) {
            throw new \RuntimeException('Unable to pick a new locale: no locale is available after applying exclusions.');
        }

        return $this->registerLocale($code);
    }

    private function registerLocale(string $code): array
    {
        $local = $this->localeProvider->getLocaleByCode($code);

        if ('fr_FR' === $code) {
            self::$frFrAdded = true;
        }
        if ('en_US' === $code) {
            self::$enUSTried = true;
        }

        self::$catalogUsedLocale[] = $code;
        self::$allUsedLocale[] = $code;

        return $local;
    }
}
