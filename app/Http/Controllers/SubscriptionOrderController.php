<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\SubscriptionOrder;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionOrderNotification;

class SubscriptionOrderController extends Controller {
    public function store( Request $request ) {
        // Validate request
        $validated = $request->validate( [
            'name'              => 'required|string|max:255',
            'phone'             => 'required|string|max:50',
            'email'             => 'required|email',
            'subscription_type' => 'required|string',
            'customer_type'     => 'required|in:individual,company',
            'policy_accepted'   => 'accepted'
        ] );
        $validated['policy_accepted'] = $request->boolean('policy_accepted');
        // Save to DB
        $order = SubscriptionOrder::create( $validated );

        try {
            Mail::to('masyanov.aleksei@gmail.com')->send(new SubscriptionOrderNotification($order));
            Mail::to($order->email)->send(new SubscriptionOrderNotification($order, true));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке почты: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json( [
            'success' => true,
            'message' => 'Спасибо! Ваша заявка отправлена.'
        ] );
    }
}

