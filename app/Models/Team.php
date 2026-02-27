<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'team_code',
        'name',
        'desc',
        'active',
    ];

    /**
     * Отношение команды к ее тренеру.
     * Столбец 'user_id' в таблице 'teams' является внешним ключом к таблице 'users' (тренеру).
     */
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(User::class, 'team_code');
    }

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }
}
