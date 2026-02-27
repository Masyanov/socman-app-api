<?php

namespace App\Http\Controllers;

use App\Services\DockerBotService;

class DockerBotController extends Controller {
    public function __construct(private DockerBotService $dockerBotService) {}

    public function stop() {
        return response()->json($this->dockerBotService->stop());
    }

    public function remove() {
        return response()->json($this->dockerBotService->remove());
    }

    public function run() {
        return response()->json($this->dockerBotService->run());
    }

    public function restart() {
        return response()->json($this->dockerBotService->restart());
    }

    public function status() {
        return response()->json($this->dockerBotService->status());
    }
}
