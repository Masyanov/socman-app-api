<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
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
        'pain',
        'local',
        'sleep',
        'sleep_time',
        'moral',
        'physical',
        'presence_checkNum',
        'cause',
        'recovery',
        'load',
    ];

    public function team()
    {
        return $this->hasOne(Team::class, 'team_code', 'team_code');
    }
}
