<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function handle(Request $request)
{
    $payload = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');
    $endpointSecret = config('services.stripe.webhook_secret');

    try {
        $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
    } catch (\Exception $e) {
        return response('Invalid payload or signature', 400);
    }

    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;
        $bookingId = $session->client_reference_id;
        $booking = \App\Models\Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status'=>'confirmed']);
            $payment = $booking->payment;
            if ($payment) {
                $payment->update(['status'=>'paid','provider_payment_id'=>$session->id,'meta'=>json_decode(json_encode($session), true)]);
            }
        }
    }
    return response('ok',200);
}

}
