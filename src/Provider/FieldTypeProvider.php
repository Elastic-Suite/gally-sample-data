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
 * Provides field type templates and configuration.
 */
class FieldTypeProvider
{
    public const TYPE_SELECT = 'select';
    public const TYPE_TEXT = 'text';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_FLOAT = 'float';
    public const TYPE_INT = 'int';

    /**
     * Distribution of field types (percentages must sum to 100).
     */
    private const TYPE_DISTRIBUTION = [
        self::TYPE_SELECT => 40,
        self::TYPE_TEXT => 30,
        self::TYPE_BOOLEAN => 15,
        self::TYPE_FLOAT => 10,
        self::TYPE_INT => 5,
    ];

    /**
     * Field templates by type.
     */
    private const FIELD_TEMPLATES = [
        self::TYPE_SELECT => [
            ['code' => 'brand', 'label' => 'Brand', 'options_count' => [10, 50]],
            ['code' => 'color', 'label' => 'Color', 'options_count' => [15, 30]],
            ['code' => 'size', 'label' => 'Size', 'options_count' => [5, 20]],
            ['code' => 'material', 'label' => 'Material', 'options_count' => [10, 30]],
            ['code' => 'manufacturer', 'label' => 'Manufacturer', 'options_count' => [10, 40]],
            ['code' => 'gender', 'label' => 'Gender', 'options_count' => [3, 5]],
            ['code' => 'style', 'label' => 'Style', 'options_count' => [8, 25]],
            ['code' => 'pattern', 'label' => 'Pattern', 'options_count' => [5, 15]],
            ['code' => 'season', 'label' => 'Season', 'options_count' => [4, 4]],
            ['code' => 'collection', 'label' => 'Collection', 'options_count' => [5, 20]],
            ['code' => 'country_of_manufacture', 'label' => 'Country of Manufacture', 'options_count' => [50, 195]],
            ['code' => 'certification', 'label' => 'Certification', 'options_count' => [5, 15]],
            ['code' => 'warranty', 'label' => 'Warranty Period', 'options_count' => [5, 10]],
        ],
        self::TYPE_TEXT => [
            ['code' => 'name', 'label' => 'Product Name'],
            ['code' => 'description', 'label' => 'Description'],
            ['code' => 'short_description', 'label' => 'Short Description'],
            ['code' => 'meta_title', 'label' => 'Meta Title'],
            ['code' => 'meta_description', 'label' => 'Meta Description'],
            ['code' => 'meta_keywords', 'label' => 'Meta Keywords'],
            ['code' => 'features', 'label' => 'Features'],
            ['code' => 'specifications', 'label' => 'Specifications'],
            ['code' => 'ingredients', 'label' => 'Ingredients'],
            ['code' => 'care_instructions', 'label' => 'Care Instructions'],
        ],
        self::TYPE_BOOLEAN => [
            ['code' => 'is_new', 'label' => 'Is New'],
            ['code' => 'is_featured', 'label' => 'Is Featured'],
            ['code' => 'in_stock', 'label' => 'In Stock'],
            ['code' => 'is_eco_friendly', 'label' => 'Eco-Friendly'],
            ['code' => 'is_sale', 'label' => 'On Sale'],
            ['code' => 'is_bestseller', 'label' => 'Bestseller'],
            ['code' => 'free_shipping', 'label' => 'Free Shipping'],
            ['code' => 'gift_wrapping_available', 'label' => 'Gift Wrapping Available'],
        ],
        self::TYPE_FLOAT => [
            ['code' => 'price', 'label' => 'Price'],
            ['code' => 'special_price', 'label' => 'Special Price'],
            ['code' => 'weight', 'label' => 'Weight'],
            ['code' => 'rating', 'label' => 'Rating'],
            ['code' => 'discount_percentage', 'label' => 'Discount Percentage'],
            ['code' => 'width', 'label' => 'Width'],
            ['code' => 'height', 'label' => 'Height'],
            ['code' => 'depth', 'label' => 'Depth'],
        ],
        self::TYPE_INT => [
            ['code' => 'quantity', 'label' => 'Quantity'],
            ['code' => 'position', 'label' => 'Position'],
            ['code' => 'review_count', 'label' => 'Review Count'],
            ['code' => 'views_count', 'label' => 'Views Count'],
            ['code' => 'sales_count', 'label' => 'Sales Count'],
        ],
    ];

    /**
     * Get a random type based on distribution.
     */
    public function getRandomType(): string
    {
        $random = random_int(1, 100);
        $cumulative = 0;

        foreach (self::TYPE_DISTRIBUTION as $type => $percentage) {
            $cumulative += $percentage;
            if ($random <= $cumulative) {
                return $type;
            }
        }

        return self::TYPE_SELECT; // Fallback
    }

    /**
     * Get a random template for a specific type.
     *
     * @return array<string, mixed>
     */
    public function getRandomTemplateForType(string $type): array
    {
        $templates = self::FIELD_TEMPLATES[$type] ?? [];

        if (empty($templates)) {
            throw new \InvalidArgumentException(\sprintf('No templates available for type "%s"', $type));
        }

        return $templates[array_rand($templates)];
    }

    /**
     * Get all templates for a specific type.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getTemplatesForType(string $type): array
    {
        return self::FIELD_TEMPLATES[$type] ?? [];
    }
}
