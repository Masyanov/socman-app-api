<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionOrder;
use App\Services\SmartCaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Mail\SubscriptionOrderNotification;

class SubscriptionOrderController extends Controller {
    // comments in code are in English as requested

    public function store( Request $request ) {
        try {
            if ( empty( config( 'services.yandex_smart_captcha.server_key' ) ) ) {
                \Log::warning( 'Subscription order: YANDEX_SMART_CAPTCHA_SERVER_KEY not set' );

                return response()->json( [
                    'success' => false,
                    'message' => __( 'messages.Ошибка проверки безопасности. Обновите страницу.' ),
                ], 422 );
            }

            // Validate input
            $validator = Validator::make( $request->all(), [
                'name'                 => 'required|string|max:255',
                'phone'                => 'required|string|max:50',
                'email'                => 'required|email',
                'subscription_type'    => 'required|string|max:100',
                'customer_type'        => 'required|in:individual,company',
                'smart-token'          => 'required|string',
                'policy_accepted'      => 'required|accepted',
            ] );

            $validator->validate();

            $token   = $request->input( 'smart-token' );
            $service = new SmartCaptchaService();
            $result  = $service->verify( $token );

            \Log::info( 'SmartCaptcha result', [
                'status'  => $result['status'] ?? 'unknown',
                'success' => $result['success'] ?? false,
            ] );

            if ( empty( $result['success'] ) ) {
                return response()->json( [
                    'success' => false,
                    'message' => __('messages.Ошибка проверки безопасности. Обновите страницу.')
                ], 422 );
            }

            // Prepare data to save (do not save smart-token)
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

            return response()->json( [ 'success' => true, 'message' => __('messages.Спасибо! Ваша заявка отправлена.') ] );

        } catch ( ValidationException $e ) {
            return response()->json( [
                'success' => false,
                'message' => __('messages.Пожалуйста, заполните все обязательные поля правильно.'),
                'errors'  => $e->errors()
            ], 422 );
        } catch ( \Exception $e ) {
            \Log::error( 'Subscription Order Error: ' . $e->getMessage() );

            return response()->json( [
                'success' => false,
                'message' => __('messages.Произошла внутренняя ошибка. Попробуйте еще раз.')
            ], 500 );
        }
    }
}
