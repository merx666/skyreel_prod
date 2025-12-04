<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request, Product $product)
    {
        // Create pending order
        $order = Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'amount' => $product->price,
            'currency' => 'pln',
            'status' => 'pending',
        ]);

        return $request->user()->checkout([$product->price_id => 1], [
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'client_reference_id' => $order->id, // Link Stripe session to our Order
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pln',
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->description,
                        'images' => $product->image_url ? [$product->image_url] : [],
                    ],
                    'unit_amount' => (int) ($product->price * 100), // Amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);
    }

    public function success(Request $request)
    {
        return redirect()->route('store.index')->with('success', 'Płatność zakończona sukcesem! Dziękujemy za zakup.');
    }

    public function cancel()
    {
        return redirect()->route('store.index')->with('error', 'Płatność została anulowana.');
    }
}
