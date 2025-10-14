<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionOrder;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Mail\SubscriptionOrderNotification;

class SubscriptionOrderController extends Controller {
    // comments in code are in English as requested

    public function store( Request $request ) {
        try {
            // Validate input
            $validator = Validator::make( $request->all(), [
                'name'                 => 'required|string|max:255',
                'phone'                => 'required|string|max:50',
                'email'                => 'required|email',
                'subscription_type'    => 'required|string',
                'customer_type'        => 'required|in:individual,company',
                'g-recaptcha-response' => 'required|string',
                'policy_accepted'      => 'required|accepted',
            ] );

            $validator->validate();

            // Get token and verify
            $token            = $request->input( 'g-recaptcha-response' );
            $recaptchaService = new RecaptchaService();
            $recaptchaResult  = $recaptchaService->verify( $token );

            \Log::info( 'reCAPTCHA result', [
                'success' => $recaptchaResult['success'] ?? false,
                'score'   => $recaptchaResult['score'] ?? 'unknown',
                'errors'  => $recaptchaResult['error-codes'] ?? []
            ] );

            if ( empty( $recaptchaResult['success'] ) ) {
                return response()->json( [
                    'success' => false,
                    'message' => 'Ошибка проверки безопасности. Обновите страницу.'
                ], 422 );
            }

            // Prepare data to save (do not save g-recaptcha-response)
            $saveData                    = $request->only( [
                'name',
                'phone',
                'email',
                'subscription_type',
                'customer_type'
            ] );
            $saveData['policy_accepted'] = $request->has( 'policy_accepted' ) ? 1 : 0;

            $order = SubscriptionOrder::create( $saveData );

            try {
                Mail::to( 'masyanov.aleksei@gmail.com' )->send( new SubscriptionOrderNotification( $order ) );
                Mail::to( $order->email )->send( new SubscriptionOrderNotification( $order, true ) );
            } catch ( \Exception $e ) {
                \Log::error( 'Email sending error: ' . $e->getMessage() );
            }

            return response()->json( [ 'success' => true, 'message' => 'Спасибо! Ваша заявка отправлена.' ] );

        } catch ( ValidationException $e ) {
            return response()->json( [
                'success' => false,
                'message' => 'Пожалуйста, заполните все обязательные поля правильно.',
                'errors'  => $e->errors()
            ], 422 );
        } catch ( \Exception $e ) {
            \Log::error( 'Subscription Order Error: ' . $e->getMessage() );

            return response()->json( [
                'success' => false,
                'message' => 'Произошла внутренняя ошибка. Попробуйте еще раз.'
            ], 500 );
        }
    }
}
