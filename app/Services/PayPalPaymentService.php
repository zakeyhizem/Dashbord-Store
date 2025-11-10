<?php

namespace App\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;

class PayPalPaymentService
{
    protected $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('payment.gateways.paypal.client_id'),
                config('payment.gateways.paypal.secret')
            )
        );

        $this->apiContext->setConfig([
            'mode' => config('payment.gateways.paypal.mode'),
        ]);
    }

    /**
     * Create a payment
     *
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @param string $returnUrl
     * @param string $cancelUrl
     * @return Payment
     */
    public function createPayment(float $amount, string $currency, string $description, string $returnUrl, string $cancelUrl): Payment
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amountObj = new Amount();
        $amountObj->setTotal($amount)
            ->setCurrency($currency);

        $transaction = new Transaction();
        $transaction->setAmount($amountObj)
            ->setDescription($description);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        $payment->create($this->apiContext);

        return $payment;
    }

    /**
     * Execute a payment
     *
     * @param string $paymentId
     * @param string $payerId
     * @return Payment
     */
    public function executePayment(string $paymentId, string $payerId): Payment
    {
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        return $payment->execute($execution, $this->apiContext);
    }
}
