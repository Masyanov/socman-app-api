<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementType extends Model
{
    protected $fillable = ['name', 'key', 'unit', 'is_lower_better'];

    // Связь: Один тип может иметь много записей от разных игроков
    public function achievements()
    {
        return $this->hasMany(PlayerAchievement::class);
    }

    // Связь: Какие тренеры выбрали этот тип достижения
    public function coaches()
    {
        return $this->belongsToMany(User::class, 'achievement_type_user');
    }
}
