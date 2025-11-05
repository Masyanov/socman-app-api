<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerTest extends Model
{
    use HasFactory;

    /**
     * Поля, которые разрешено массово присваивать.
     * ЭТО КЛЮЧЕВОЙ МОМЕНТ ДЛЯ РАБОТЫ ИМПОРТА!
     */
    protected $fillable = [
        'player_id',
        'date_of_test',
        'position',
        'status',
        'height',
        'weight',
        'body_mass_index',
        'push_ups',
        'pull_ups',
        'ten_m',
        'twenty_m',
        'thirty_m',
        'long_jump',
        'vertical_jump_no_hands',
        'vertical_jump_with_hands',
        'illinois_test',
        'pause_one',
        'pause_two',
        'pause_three',
        'step',
        'mpk',
        'level',
        // Убедитесь, что ВСЕ поля из вашего импорта перечислены здесь!
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     */
    protected $casts = [
        'date_of_test' => 'date', // Laravel автоматически преобразует в Carbon
        // Остальные числовые поля можно привести к float или int
        'height' => 'integer',
        'weight' => 'float',
        'body_mass_index' => 'float',
        'push_ups' => 'integer',
        'pull_ups' => 'integer',
        'ten_m' => 'float',
        'twenty_m' => 'float',
        'thirty_m' => 'float',
        'long_jump' => 'integer',
        'vertical_jump_no_hands' => 'integer',
        'vertical_jump_with_hands' => 'integer',
        'illinois_test' => 'float',
        'pause_one' => 'float',
        'pause_two' => 'float',
        'pause_three' => 'float',
        'step' => 'float',
        'mpk' => 'float',
        'level' => 'integer',
    ];

    /**
     * Определение отношения с моделью User.
     * Предполагается, что 'player_id' - это внешний ключ к таблице 'users'.
     */
    public function user()
    {
        return $this->belongsTo(User::class,  'player_id', 'id');
    }
}

