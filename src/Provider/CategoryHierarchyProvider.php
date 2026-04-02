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

use Random\Engine\Xoshiro256StarStar;
use Random\Randomizer;

/**
 * Provides category hierarchy structure for test data generation.
 * Builds a realistic category tree with controlled depth and width.
 */
class CategoryHierarchyProvider
{
    /**
     * Base category hierarchy templates - realistic category structures.
     *
     * @var array<string, array<string, mixed>>
     */
    private const PRIMARY_HIERARCHY = [
        'fashion' => [
            'men' => [
                'clothing' => ['tshirts', 'pants', 'jackets', 'sweaters', 'suits', 'casual', 'formal', 'sportswear'],
                'shoes' => ['sneakers', 'boots', 'dress_shoes', 'sandals', 'slippers'],
                'accessories' => ['watches', 'belts', 'wallets', 'ties', 'cufflinks'],
            ],
            'women' => [
                'clothing' => ['dresses', 'skirts', 'blouses', 'pants', 'jackets', 'evening_wear', 'casual', 'sportswear'],
                'shoes' => ['heels', 'flats', 'boots', 'sandals', 'sneakers'],
                'accessories' => ['jewelry', 'handbags', 'scarves', 'sunglasses'],
            ],
            'kids' => [
                'boys' => ['tops', 'bottoms', 'outerwear', 'shoes', 'accessories'],
                'girls' => ['dresses', 'tops', 'bottoms', 'outerwear', 'shoes', 'accessories'],
                'babies' => ['bodysuits', 'sleepwear', 'outerwear', 'shoes'],
                'school_uniforms' => ['shirts', 'pants', 'skirts', 'shoes'],
            ],
        ],
        'electronics' => [
            'computers' => [
                'laptops' => ['gaming_laptops', 'business_laptops', 'ultrabooks', 'chromebooks'],
                'desktops' => ['gaming_pcs', 'workstations', 'all_in_one', 'mini_pcs'],
                'tablets' => ['android_tablets', 'ipads', 'windows_tablets'],
                'accessories' => ['monitors', 'keyboards', 'mice', 'webcams', 'docking_stations'],
            ],
            'phones' => [
                'smartphones' => ['android', 'iphones', 'budget_phones', 'flagship_phones'],
                'feature_phones' => ['basic_phones', 'senior_phones'],
                'accessories' => ['cases', 'screen_protectors', 'chargers', 'headphones'],
            ],
            'audio' => [
                'headphones' => ['wireless', 'wired', 'gaming_headsets', 'earbuds'],
                'speakers' => ['bluetooth_speakers', 'smart_speakers', 'soundbars', 'home_theater'],
                'portable' => ['mp3_players', 'portable_speakers'],
            ],
            'gaming' => [
                'consoles' => ['playstation', 'xbox', 'nintendo', 'handheld'],
                'games' => ['action', 'adventure', 'sports', 'racing', 'rpg'],
                'accessories' => ['controllers', 'vr_headsets', 'gaming_chairs', 'capture_cards'],
            ],
        ],
        'home_garden' => [
            'furniture' => [
                'living_room' => ['sofas', 'armchairs', 'coffee_tables', 'tv_stands', 'bookcases'],
                'bedroom' => ['beds', 'mattresses', 'nightstands', 'dressers', 'wardrobes'],
                'office' => ['desks', 'office_chairs', 'filing_cabinets', 'shelving'],
                'outdoor' => ['patio_furniture', 'garden_benches', 'hammocks'],
            ],
            'kitchen' => [
                'appliances' => ['refrigerators', 'ovens', 'microwaves', 'dishwashers', 'coffee_makers'],
                'cookware' => ['pots_pans', 'bakeware', 'knives', 'cutting_boards'],
                'utensils' => ['spatulas', 'whisks', 'measuring_cups', 'graters'],
                'storage' => ['containers', 'jars', 'organizers'],
            ],
            'decoration' => [
                'wall_art' => ['paintings', 'prints', 'posters', 'mirrors'],
                'lighting' => ['ceiling_lights', 'table_lamps', 'floor_lamps', 'smart_bulbs'],
                'textiles' => ['rugs', 'curtains', 'cushions', 'throws'],
            ],
            'garden' => [
                'tools' => ['hand_tools', 'power_tools', 'watering_equipment'],
                'plants' => ['flowers', 'vegetables', 'herbs', 'trees', 'indoor_plants'],
                'outdoor' => ['bbq_grills', 'fire_pits', 'planters', 'garden_decor'],
            ],
        ],
        'sports' => [
            'outdoor' => [
                'hiking' => ['backpacks', 'boots', 'tents', 'sleeping_bags', 'trekking_poles'],
                'camping' => ['tents', 'sleeping_bags', 'camp_stoves', 'coolers'],
                'cycling' => ['bikes', 'helmets', 'accessories', 'clothing'],
                'water_sports' => ['surfboards', 'kayaks', 'life_jackets', 'wetsuits'],
            ],
            'fitness' => [
                'cardio' => ['treadmills', 'exercise_bikes', 'ellipticals', 'rowing_machines'],
                'weights' => ['dumbbells', 'barbells', 'weight_benches', 'kettlebells'],
                'yoga' => ['mats', 'blocks', 'straps', 'meditation_cushions'],
                'accessories' => ['resistance_bands', 'foam_rollers', 'gym_bags'],
            ],
            'team_sports' => [
                'football' => ['balls', 'cleats', 'shin_guards', 'jerseys'],
                'basketball' => ['balls', 'shoes', 'jerseys', 'hoops'],
                'baseball' => ['bats', 'gloves', 'balls', 'helmets'],
                'volleyball' => ['balls', 'nets', 'knee_pads'],
            ],
            'winter_sports' => [
                'skiing' => ['skis', 'boots', 'poles', 'goggles', 'jackets'],
                'snowboarding' => ['boards', 'boots', 'bindings', 'protective_gear'],
                'ice_skating' => ['skates', 'protective_gear', 'accessories'],
            ],
        ],
        'culture_entertainment' => [
            'books' => [
                'fiction' => ['mystery', 'romance', 'scifi', 'fantasy', 'thriller', 'classics'],
                'non_fiction' => ['biography', 'history', 'science', 'self_help', 'cookbooks'],
                'comics' => ['manga', 'graphic_novels', 'superhero', 'indie'],
                'childrens_books' => ['picture_books', 'young_adult', 'educational'],
            ],
            'music' => [
                'physical_media' => ['cds', 'vinyl_records', 'cassettes'],
                'instruments' => ['guitars', 'keyboards', 'drums', 'wind_instruments', 'strings'],
                'accessories' => ['sheet_music', 'music_stands', 'cases', 'tuners'],
            ],
            'movies_tv' => [
                'physical_media' => ['dvds', 'blu_rays', '4k_ultra_hd'],
                'merchandise' => ['posters', 'figures', 'clothing', 'collectibles'],
            ],
        ],
    ];

    /**
     * Cross-domain wrapper categories: top-level categories whose children
     * are drawn from PRIMARY_HIERARCHY domains rather than a dedicated subtree.
     *
     * @var array<int, string>
     */
    private const CROSS_DOMAIN_WRAPPERS = [
        'sales_promotions',
        'new_arrivals',
        'seasonal',
    ];

    /**
     * Generic sub-category names that can extend any leaf node
     * to create deeper hierarchy levels beyond PRIMARY_HIERARCHY depth.
     *
     * @var array<int, string>
     */
    private const LEAF_EXTENDERS = [
        'accessories',
        'essentials',
        'selection',
        'best_sellers',
        'premium',
        'bundles',
    ];

    private Randomizer $randomizer;

    /**
     * Generate a nested category tree.
     *
     * Each node is:
     *   ['code' => string, 'suffix' => string, 'children' => [...]]
     *
     * @return array<int, array{code: string, suffix: string, children: array<mixed>}>
     */
    public function generateHierarchy(
        int $totalCategoryCount,
        int $maxDepth,
        int $seed,
    ): array {
        $this->randomizer = new Randomizer(new Xoshiro256StarStar($seed));
        $avgChildCount = max(2, (int) round($totalCategoryCount ** (1.0 / $maxDepth)));

        $rootPool = array_merge(
            self::PRIMARY_HIERARCHY,
            array_fill_keys(self::CROSS_DOMAIN_WRAPPERS, self::PRIMARY_HIERARCHY),
        );

        return $this->buildChildren($rootPool, 1, $maxDepth, $avgChildCount);
    }

    /**
     * @param array<mixed> $pool
     *
     * @return array<int, array{code: string, suffix: string, children: array<mixed>}>
     */
    private function buildChildren(
        array $pool,
        int $currentLevel,
        int $maxDepth,
        int $avgChildCount,
    ): array {
        if ($currentLevel > $maxDepth) {
            return [];
        }

        $poolKeys = array_is_list($pool) ? $pool : array_keys($pool);
        $this->randomizer->shuffleArray($poolKeys);

        // Apply a ±20% random variation to the average child count to avoid perfectly uniform trees.
        $randomFactor = 0.9 + $this->randomizer->getInt(0, 200) / 1000.0;
        $nbChildren = (int) round($avgChildCount * $randomFactor);
        if (1 === $currentLevel) {
            $nbChildren = max(4, min(10, $nbChildren));
        }

        $usedCodes = [];
        $children = [];

        for ($i = 0; $i < $nbChildren; ++$i) {
            // The pool is pre-shuffled, so iterating sequentially gives a random order.
            // The modulo wraps around if $nbChildren exceeds the pool size.
            $code = $poolKeys[$i % \count($poolKeys)];
            $suffix = $usedCodes[$code] ?? '';
            $usedCodes[$code] = $this->nextSuffix($suffix);

            $childPool = (!array_is_list($pool) && isset($pool[$code]) && \is_array($pool[$code]))
                ? $pool[$code]
                : self::LEAF_EXTENDERS;

            $children[] = [
                'code' => $code,
                'suffix' => $suffix,
                'children' => $this->buildChildren($childPool, $currentLevel + 1, $maxDepth, $avgChildCount),
            ];
        }

        return $children;
    }

    private function nextSuffix(string $current): string
    {
        if ('' === $current) {
            return '2';
        }

        return (string) ((int) $current + 1);
    }
}
