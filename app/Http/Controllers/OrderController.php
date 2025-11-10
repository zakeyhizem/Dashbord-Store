<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripePaymentService;
use App\Services\PayPalPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['user', 'products', 'payment'])->paginate(15);
        return response()->json($orders);
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:stripe,paypal,cash',
            'shipping_address' => 'required|array',
            'billing_address' => 'nullable|array',
        ]);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($validated['products'] as $productData) {
            $product = \App\Models\Product::find($productData['id']);
            $totalAmount += $product->price * $productData['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'shipping_address' => $validated['shipping_address'],
            'billing_address' => $validated['billing_address'] ?? $validated['shipping_address'],
        ]);

        // Attach products
        foreach ($validated['products'] as $productData) {
            $product = \App\Models\Product::find($productData['id']);
            $order->products()->attach($productData['id'], [
                'quantity' => $productData['quantity'],
                'price' => $product->price,
            ]);
        }

        return response()->json($order->load(['products', 'user']), 201);
    }

    /**
     * Display the specified order
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load(['user', 'products', 'payment']));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'in:pending,processing,completed,cancelled',
            'payment_status' => 'in:pending,paid,failed,refunded',
        ]);

        $order->update($validated);
        return response()->json($order);
    }

    /**
     * Remove the specified order
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
