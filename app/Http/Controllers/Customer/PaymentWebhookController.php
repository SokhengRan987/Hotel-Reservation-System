<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /**
     * Handle Stripe webhook events.
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();

        // Log the raw payload for debugging
        Log::info('Stripe Webhook Received:', ['payload' => $payload]);

        // You can later handle specific event types, for example:
        // $event = json_decode($payload);
        // if ($event->type === 'checkout.session.completed') {
        //     // Update booking/payment status logic here
        // }

        return response()->json(['status' => 'success']);
    }
}
