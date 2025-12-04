<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends CashierController
{
    /**
     * Handle checkout session completed.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCheckoutSessionCompleted($payload)
    {
        $session = $payload['data']['object'];

        if (isset($session['client_reference_id'])) {
            $order = Order::find($session['client_reference_id']);

            if ($order && $order->status === 'pending') {
                $order->update([
                    'status' => 'paid',
                    'stripe_session_id' => $session['id'],
                ]);
            }
        }

        return new Response('Webhook Handled', 200);
    }
}
