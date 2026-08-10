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

use Random\Randomizer;

class ProductNameProvider
{
    /**
     * Mapping of level 1 categories with coherent nouns, adjectives, colors and sizes.
     *
     * @var array<string, array{nouns: string[], adjectives: string[], colors?: string[], sizes?: string[]}>
     */
    private const CATEGORY_PRODUCT_MAPPING = [
        'fashion' => [
            'nouns' => [
                'tshirts',
                'pants',
                'jackets',
                'sweaters',
                'dresses',
                'skirts',
                'blouses',
                'sneakers',
                'boots',
                'heels',
                'handbags',
                'watches',
                'belts',
                'suits',
                'scarves',
            ],
            'adjectives' => [
                'cotton',
                'polyester',
                'wool',
                'silk',
                'linen',
                'denim',
                'leather',
                'suede',
                'vintage',
                'classic',
                'modern',
                'elegant',
                'casual',
                'sporty',
                'premium',
                'luxury',
                'eco_friendly',
                'sustainable',
                'stylish',
                'trendy',
                'timeless',
                'bold',
                'minimalist',
                'colorful',
                'neutral',
            ],
            'colors' => [
                'black',
                'white',
                'red',
                'blue',
                'green',
                'yellow',
                'pink',
                'purple',
                'orange',
                'brown',
                'gray',
                'navy',
                'beige',
                'cream',
                'gold',
                'silver',
                'rose_gold',
                'multicolor',
                'striped',
                'floral',
                'animal_print',
            ],
            'sizes' => ['xs', 's', 'm', 'l', 'xl', 'xxl'],
        ],
        'electronics' => [
            'nouns' => [
                'laptops',
                'gaming_laptops',
                'ultrabooks',
                'tablets',
                'smartphones',
                'monitors',
                'keyboards',
                'headphones',
                'speakers',
                'webcams',
                'controllers',
                'earbuds',
                'soundbars',
            ],
            'adjectives' => [
                'lightweight',
                'durable',
                'premium',
                'modern',
                'compact',
                'portable',
                'professional',
                'advanced',
                'smart',
                'wireless',
                'waterproof',
                'breathable',
                'ultra',
                'pro',
                'slim',
                'eco',
                'essential',
            ],
            'colors' => [
                'black',
                'white',
                'silver',
                'gold',
                'space_gray',
                'blue',
                'red',
                'rose_gold',
                'platinum',
                'gunmetal',
                'chrome',
            ],
            'sizes' => ['s', 'm', 'l', 'xl'],
        ],
        'home_garden' => [
            'nouns' => [
                'sofas',
                'beds',
                'desks',
                'mattresses',
                'rugs',
                'curtains',
                'lamps',
                'table_lamps',
                'floor_lamps',
                'pots_pans',
                'knives',
                'coffee_makers',
                'planters',
            ],
            'adjectives' => [
                'comfortable',
                'elegant',
                'modern',
                'vintage',
                'minimalist',
                'colorful',
                'durable',
                'premium',
                'luxury',
                'eco_friendly',
                'sustainable',
                'stylish',
                'classic',
                'spacious',
                'compact',
                'professional',
                'handmade',
            ],
            'colors' => [
                'black',
                'white',
                'beige',
                'gray',
                'brown',
                'cream',
                'navy',
                'green',
                'charcoal',
                'ivory',
                'taupe',
                'tan',
                'terracotta',
                'sand',
            ],
            'sizes' => ['s', 'm', 'l', 'xl', 'xxl'],
        ],
        'sports' => [
            'nouns' => [
                'backpacks',
                'tents',
                'sleeping_bags',
                'treadmills',
                'dumbbells',
                'mats',
                'bikes',
                'helmets',
                'skis',
                'balls',
            ],
            'adjectives' => [
                'lightweight',
                'durable',
                'waterproof',
                'breathable',
                'comfortable',
                'sporty',
                'professional',
                'advanced',
                'eco_friendly',
                'sustainable',
                'premium',
                'flexible',
                'rigid',
                'portable',
                'compact',
            ],
            'colors' => [
                'black',
                'white',
                'red',
                'blue',
                'green',
                'yellow',
                'orange',
                'gray',
                'navy',
                'forest',
                'emerald',
            ],
            'sizes' => ['xs', 's', 'm', 'l', 'xl', 'xxl'],
        ],
        'culture_entertainment' => [
            'nouns' => [
                'mystery',
                'scifi',
                'biography',
                'guitars',
                'keyboards_instruments',
                'vinyl_records',
            ],
            'adjectives' => [
                'classic',
                'modern',
                'vintage',
                'premium',
                'exclusive',
                'limited_edition',
                'bestseller',
                'new_arrival',
                'artistic',
                'handmade',
                'professional',
                'timeless',
                'trendy',
                'elegant',
            ],
            'colors' => [
                'black',
                'white',
                'red',
                'blue',
                'gold',
                'silver',
                'burgundy',
                'forest',
            ],
            'sizes' => ['one_size'],
        ],
    ];

    /**
     * Generates a product name coherent with the category hierarchy.
     *
     * @param array<int, string> $categoryCodes Category code hierarchy (ex: ['root', 'fashion', 'men', 'clothing'])
     * @param string             $sku           Product SKU used as seed for reproducibility
     *
     * @return string Generated product name
     */
    public function generateProductName(
        array $categoryCodes,
        string $sku,
    ): string {
        // Create a local randomizer seeded with the SKU
        $seed = crc32($sku);
        $randomizer = new Randomizer(new \Random\Engine\Xoshiro256StarStar($seed));

        // Find the first code that matches a domain category
        $matches = array_intersect($categoryCodes, array_keys(self::CATEGORY_PRODUCT_MAPPING));
        $domainCategory = reset($matches) ?: array_key_first(self::CATEGORY_PRODUCT_MAPPING);
        $categoryProducts = self::CATEGORY_PRODUCT_MAPPING[$domainCategory];

        // Randomly select a noun and an adjective
        $noun = $categoryProducts['nouns'][$randomizer->getInt(0, \count($categoryProducts['nouns']) - 1)];
        $adjective = $categoryProducts['adjectives'][$randomizer->getInt(0, \count($categoryProducts['adjectives']) - 1)];

        // Optionally select color and size
        $color = $categoryProducts['colors'][$randomizer->getInt(0, \count($categoryProducts['colors']) - 1)];
        $size = $categoryProducts['sizes'][$randomizer->getInt(0, \count($categoryProducts['sizes']) - 1)];

        // Randomly choose the name format (8 possible formats with colors/sizes)
        $format = $randomizer->getInt(0, 7);

        return match ($format) {
            0 => "gally.product.adjective.$adjective gally.product.noun.$noun",
            1 => "gally.product.noun.$noun gally.product.adjective.$adjective",
            3 => "gally.product.adjective.$adjective gally.product.noun.$noun gally.product.color.$color",
            4 => "gally.product.noun.$noun gally.product.color.$color",
            5 => "gally.product.adjective.$adjective gally.product.noun.$noun gally.product.size.$size",
            6 => "gally.product.noun.$noun gally.product.color.$color gally.product.size.$size",
            default => "gally.product.adjective.$adjective gally.product.noun.$noun gally.product.color.$color gally.product.size.$size",
        };
    }
}
