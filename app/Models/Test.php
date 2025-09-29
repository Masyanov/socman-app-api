<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model
{
    // Если нужно, укажите имя таблицы, иначе Laravel будет искать tests
    // protected $table = 'tests';

    // Разрешённые для массового присвоения поля (укажите нужные)
    protected $fillable = [
        'user_id',
        'team_code',
        'date_of_test',
        'full_name',
        'photo',
        'date_of_birth',
        'leading_leg',
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
    ];

    /**
     * Get the user that owns the test record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
