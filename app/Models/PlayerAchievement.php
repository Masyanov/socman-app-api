<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerAchievement extends Model
{
    protected $fillable = [
        'user_id',
        'achievement_type_id',
        'value',
        'recorded_at',
        'comment'
    ];

    protected $casts = [
        'recorded_at' => 'date',
        'value' => 'decimal:2'
    ];

    public function type()
    {
        return $this->belongsTo(AchievementType::class, 'achievement_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
