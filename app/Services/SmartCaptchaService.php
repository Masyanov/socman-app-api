<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Yandex Smart Captcha (Умная капча) — проверка токена на сервере.
 * Документация: https://cloud.yandex.ru/docs/smartcaptcha/
 */
class SmartCaptchaService
{
    private const VALIDATE_URL = 'https://smartcaptcha.yandexcloud.net/validate';

    public function verify(string $token): array
    {
        $serverKey = config('services.yandex_smart_captcha.server_key');

        if (empty($serverKey)) {
            Log::warning('SmartCaptcha: YANDEX_SMART_CAPTCHA_SERVER_KEY not set');
            return ['status' => 'failed', 'message' => 'captcha_not_configured'];
        }

        try {
            $response = Http::timeout(10)
                ->asForm()
                ->post(self::VALIDATE_URL, [
                    'secret' => $serverKey,
                    'token'  => $token,
                    'ip'     => request()->ip(),
                ]);

            if ($response->failed()) {
                Log::error('SmartCaptcha HTTP error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return ['status' => 'failed', 'message' => 'http_error'];
            }

            $data = $response->json();
            Log::info('SmartCaptcha validate response', ['response' => $data]);

            if (isset($data['status']) && $data['status'] === 'ok') {
                Log::info('SmartCaptcha success');
                return ['status' => 'ok', 'success' => true];
            }

            $message = $data['message'] ?? 'verification_failed';
            Log::warning('SmartCaptcha verification failed', ['message' => $message, 'response' => $data]);
            return ['status' => 'failed', 'message' => $message, 'success' => false];

        } catch (\Exception $e) {
            Log::error('SmartCaptcha exception: ' . $e->getMessage());
            return ['status' => 'failed', 'message' => 'service_exception', 'success' => false];
        }
    }
}
