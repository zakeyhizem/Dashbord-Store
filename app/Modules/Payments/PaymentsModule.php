<?php

namespace App\Modules\Payments;

/**
 * Payments Module
 * 
 * This module handles all payment-related functionality including:
 * - Multiple payment gateway integrations (Stripe, PayPal)
 * - Payment processing
 * - Transaction management
 * - Refunds and chargebacks
 */
class PaymentsModule
{
    /**
     * Module name
     */
    public const NAME = 'Payments';

    /**
     * Module version
     */
    public const VERSION = '1.0.0';

    /**
     * Module description
     */
    public const DESCRIPTION = 'Payment gateway integration module';

    /**
     * Supported payment gateways
     */
    public const SUPPORTED_GATEWAYS = [
        'stripe',
        'paypal',
    ];

    /**
     * Boot the module
     */
    public function boot(): void
    {
        // Register payment services
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
            'gateways' => self::SUPPORTED_GATEWAYS,
        ];
    }
}
