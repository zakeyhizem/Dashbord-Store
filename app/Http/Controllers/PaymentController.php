<?php

namespace App\Http\Controllers;

use App\Services\StripePaymentService;
use App\Services\PayPalPaymentService;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected $stripeService;
    protected $paypalService;

    public function __construct(StripePaymentService $stripeService, PayPalPaymentService $paypalService)
    {
        $this->stripeService = $stripeService;
        $this->paypalService = $paypalService;
    }

    /**
     * Create a payment with Stripe
     */
    public function createStripePayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'string|size:3',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        try {
            $paymentIntent = $this->stripeService->createPaymentIntent(
                $validated['amount'],
                $validated['currency'] ?? 'usd',
                ['order_id' => $order->id]
            );

            $payment = Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $paymentIntent->id,
                'payment_gateway' => 'stripe',
                'amount' => $validated['amount'],
                'currency' => $validated['currency'] ?? 'usd',
                'status' => 'pending',
                'metadata' => ['client_secret' => $paymentIntent->client_secret],
            ]);

            return response()->json([
                'payment' => $payment,
                'client_secret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a payment with PayPal
     */
    public function createPayPalPayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'string|size:3',
            'return_url' => 'required|url',
            'cancel_url' => 'required|url',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        try {
            $payment = $this->paypalService->createPayment(
                $validated['amount'],
                $validated['currency'] ?? 'USD',
                'Order #' . $order->order_number,
                $validated['return_url'],
                $validated['cancel_url']
            );

            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $payment->getId(),
                'payment_gateway' => 'paypal',
                'amount' => $validated['amount'],
                'currency' => $validated['currency'] ?? 'USD',
                'status' => 'pending',
            ]);

            // Get approval URL
            $approvalUrl = null;
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() === 'approval_url') {
                    $approvalUrl = $link->getHref();
                    break;
                }
            }

            return response()->json([
                'payment_id' => $payment->getId(),
                'approval_url' => $approvalUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of payments
     */
    public function index(): JsonResponse
    {
        $payments = Payment::with('order')->paginate(15);
        return response()->json($payments);
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment): JsonResponse
    {
        return response()->json($payment->load('order'));
    }
}
