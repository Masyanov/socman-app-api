<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Создаем таблицу achievement_types (СПРАВОЧНИК МЕТРИК)
        // Она должна быть первой, так как на нее ссылаются другие таблицы.
        Schema::create('achievement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название метрики (например, "Спринт 30м", "Голы")
            $table->string('key')->unique(); // Уникальный ключ для обращения в коде (например, 'sprint_30', 'goals')
            $table->string('unit'); // Единица измерения (например, "сек", "шт", "кг")
            $table->boolean('is_lower_better')->default(false); // Для графика: True = чем меньше, тем лучше (время), False = чем больше, тем лучше (голы)
            $table->timestamps();
        });

        // 2. Создаем таблицу player_achievements (ЗАПИСИ РЕЗУЛЬТАТОВ ИГРОКОВ)
        // Она ссылается на 'users' (который должен быть создан стандартной миграцией Laravel) и на 'achievement_types'.
        Schema::create('player_achievements', function (Blueprint $table) {
            $table->id();
            // ID игрока, который внес достижение (ссылается на таблицу 'users')
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // ID типа достижения из achievement_types (ссылается на только что созданную achievement_types)
            $table->foreignId('achievement_type_id')->constrained()->onDelete('cascade');
            $table->decimal('value', 10, 2); // Значение (например, 4.25 сек, 5 голов)
            $table->date('recorded_at'); // Дата, когда достижение было зафиксировано
            $table->text('comment')->nullable(); // Комментарий игрока
            $table->timestamps();

            // Индекс для быстрого поиска истории по игроку и типу достижения
            $table->index(['user_id', 'achievement_type_id']);
        });

        // 3. Создаем таблицу achievement_type_user (ПРОМЕЖУТОЧНАЯ ТАБЛИЦА ТРЕНЕР-МЕТРИКИ)
        // Она ссылается на 'users' и на 'achievement_types'.
        Schema::create('achievement_type_user', function (Blueprint $table) {
            $table->id();
            // ID пользователя (тренера) (ссылается на таблицу 'users')
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // ID типа достижения (ссылается на achievement_types)
            $table->foreignId('achievement_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Уникальная пара, чтобы тренер не мог выбрать один и тот же тип достижения дважды
            $table->unique(['user_id', 'achievement_type_id']);
        });
    }

    public function down(): void
    {
        // При откате миграций порядок должен быть обратным для корректного удаления
        Schema::dropIfExists('achievement_type_user');
        Schema::dropIfExists('player_achievements');
        Schema::dropIfExists('achievement_types');
    }
};
