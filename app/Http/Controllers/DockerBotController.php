<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DockerBotController extends Controller {
    protected $mgrUrl = 'http://docker-manager:8085';

    protected function sendToManager( $endpoint ) {
        $token = env( 'DOCKER_MANAGER_TOKEN' );
        try {
            $res = Http::withHeaders( [
                'Authorization' => 'Bearer ' . $token
            ] )->post( $this->mgrUrl . $endpoint );

            return $res->json();
        } catch ( \Throwable $e ) {
            return [ 'status' => false, 'output' => $e->getMessage() ];
        }
    }

    public function stop() {
        return response()->json( $this->sendToManager( '/stop-bot' ) );
    }

    public function remove() {
        return response()->json( $this->sendToManager( '/remove-bot' ) );
    }

    public function run() {
        return response()->json( $this->sendToManager( '/run-bot' ) );
    }

    public function restart() {
        return response()->json( $this->sendToManager( '/restart-bot' ) );
    }

    public function status() {
        $token = env( 'DOCKER_MANAGER_TOKEN' );
        try {
            $res = Http::withHeaders( [
                'Authorization' => 'Bearer ' . $token
            ] )->get( $this->mgrUrl . '/status-bot' );

            return $res->json();
        } catch ( \Throwable $e ) {
            return [ 'output' => $e->getMessage() ];
        }
    }
}
