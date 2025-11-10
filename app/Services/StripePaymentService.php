<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;

class StripePaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('payment.gateways.stripe.secret'));
    }

    /**
     * Create a payment intent
     *
     * @param float $amount
     * @param string $currency
     * @param array $metadata
     * @return PaymentIntent
     */
    public function createPaymentIntent(float $amount, string $currency = 'usd', array $metadata = []): PaymentIntent
    {
        return PaymentIntent::create([
            'amount' => $amount * 100, // Convert to cents
            'currency' => $currency,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Create a charge
     *
     * @param float $amount
     * @param string $source
     * @param string $currency
     * @param string $description
     * @return Charge
     */
    public function createCharge(float $amount, string $source, string $currency = 'usd', string $description = ''): Charge
    {
        return Charge::create([
            'amount' => $amount * 100, // Convert to cents
            'currency' => $currency,
            'source' => $source,
            'description' => $description,
        ]);
    }

    /**
     * Retrieve a payment intent
     *
     * @param string $paymentIntentId
     * @return PaymentIntent
     */
    public function retrievePaymentIntent(string $paymentIntentId): PaymentIntent
    {
        return PaymentIntent::retrieve($paymentIntentId);
    }
}
