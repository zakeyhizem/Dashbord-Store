<?php

namespace App\Modules\Products;

/**
 * Products Module
 * 
 * This module handles all product-related functionality including:
 * - Product management (CRUD operations)
 * - Inventory tracking
 * - Product categorization
 * - Product images and media
 */
class ProductsModule
{
    /**
     * Module name
     */
    public const NAME = 'Products';

    /**
     * Module version
     */
    public const VERSION = '1.0.0';

    /**
     * Module description
     */
    public const DESCRIPTION = 'Product management module';

    /**
     * Boot the module
     */
    public function boot(): void
    {
        // Register module services, routes, etc.
    }

    /**
     * Get module configuration
     */
    public function getConfig(): array
    {
        return [
            'name' => self::NAME,
            'version' => self::VERSION,
            'description' => self::DESCRIPTION,
            'enabled' => true,
        ];
    }
}
