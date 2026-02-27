<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyBotSecret
{
    public function handle(Request $request, Closure $next)
    {
        $expected = (string) config('services.telegram.bot_secret', '');
        if ($expected === '') {
            // В проде секрет должен быть задан. Если не задан — блокируем доступ.
            return response()->json(['error' => 'Bot secret is not configured'], 503);
        }

        $provided = (string) $request->header('X-Bot-Secret', '');
        if (!hash_equals($expected, $provided)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

