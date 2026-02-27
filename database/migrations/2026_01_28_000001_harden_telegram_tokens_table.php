<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Перед добавлением уникальности user_id убираем дубликаты (оставляем самую свежую запись).
        $dupes = DB::table('telegram_tokens')
            ->select('user_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('user_id')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($dupes as $d) {
            $keepId = DB::table('telegram_tokens')
                ->where('user_id', $d->user_id)
                ->max('id');

            DB::table('telegram_tokens')
                ->where('user_id', $d->user_id)
                ->where('id', '!=', $keepId)
                ->delete();
        }

        Schema::table('telegram_tokens', function (Blueprint $table) {
            // 1 пользователь ↔ 1 telegram token record
            $table->unique('user_id', 'telegram_tokens_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('telegram_tokens', function (Blueprint $table) {
            $table->dropUnique('telegram_tokens_user_id_unique');
        });
    }
};

