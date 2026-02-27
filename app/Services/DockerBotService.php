<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DockerBotService
{
    private string $baseUrl;
    private string $token;
    private int $timeout;
    private int $connectTimeout;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.docker_manager.url'), '/');
        $this->token = (string) config('services.docker_manager.token', '');
        $this->timeout = (int) config('services.docker_manager.timeout_seconds', 10);
        $this->connectTimeout = (int) config('services.docker_manager.connect_timeout_seconds', 3);
    }

    public function stop(): array { return $this->postAndNormalize('/stop-bot'); }
    public function remove(): array { return $this->postAndNormalize('/remove-bot'); }
    public function run(): array { return $this->postAndNormalize('/run-bot'); }
    public function restart(): array { return $this->postAndNormalize('/restart-bot'); }
    public function status(): array { return $this->getAndNormalize('/status-bot'); }

    private function http()
    {
        return Http::timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->retry(2, 200)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ]);
    }

    /**
     * Контракт ответа для фронта:
     * - status: bool (успех запроса к docker-manager)
     * - state: 'running'|'exited'|'unknown'
     * - output: string (человекочитаемый вывод/ошибка)
     */
    private function normalize(array $payload): array
    {
        $status = (bool) ($payload['status'] ?? false);
        $output = (string) ($payload['output'] ?? '');

        $state = 'unknown';
        if ($status) {
            if (stripos($output, 'Up') !== false || stripos($output, 'running') !== false) {
                $state = 'running';
            } elseif (stripos($output, 'Exited') !== false || stripos($output, 'exited') !== false) {
                $state = 'exited';
            }
        }

        return [
            'status' => $status,
            'state' => $state,
            'output' => $output,
        ];
    }

    private function postAndNormalize(string $endpoint): array
    {
        if ($this->token === '') {
            return $this->normalize(['status' => false, 'output' => 'DOCKER_MANAGER_TOKEN is not configured']);
        }

        try {
            $res = $this->http()->post($this->baseUrl . $endpoint);
            $json = $res->json();
            if (!is_array($json)) {
                $json = ['status' => false, 'output' => (string) $res->body()];
            }
            return $this->normalize($json);
        } catch (\Throwable $e) {
            Log::error('DockerBotService POST failed', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);
            return $this->normalize(['status' => false, 'output' => $e->getMessage()]);
        }
    }

    private function getAndNormalize(string $endpoint): array
    {
        if ($this->token === '') {
            return $this->normalize(['status' => false, 'output' => 'DOCKER_MANAGER_TOKEN is not configured']);
        }

        try {
            $res = $this->http()->get($this->baseUrl . $endpoint);
            $json = $res->json();
            if (!is_array($json)) {
                $json = ['status' => false, 'output' => (string) $res->body()];
            }
            return $this->normalize($json);
        } catch (\Throwable $e) {
            Log::error('DockerBotService GET failed', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);
            return $this->normalize(['status' => false, 'output' => $e->getMessage()]);
        }
    }
}

