<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    public function verify($token)
    {
        try {
            $response = Http::timeout(10)->asForm()->post('https://www.google.com/recaptcha/api/siteverify',[
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $token
            ]);

            if ($response->failed()) {
                Log::error('reCAPTCHA HTTP error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return ['success' => false, 'error' => 'http_error'];
            }

            $data = $response->json();

            // Детальная проверка для v3
            if (!$data['success']) {
                Log::error('reCAPTCHA verification failed', [
                    'error-codes' => $data['error-codes'] ?? []
                ]);
                return $data;
            }

            // Проверяем score для v3
            if (isset($data['score']) && $data['score'] < 0.5) {
                Log::warning('reCAPTCHA low score', ['score' => $data['score']]);
                return ['success' => false, 'score' => $data['score']];
            }

            Log::info('reCAPTCHA success', ['score' => $data['score'] ?? 'unknown']);
            return $data;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA service exception: '.$e->getMessage());
            return ['success' => false, 'error' => 'service_exception'];
        }
    }
}
