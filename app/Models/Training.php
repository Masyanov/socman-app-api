<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public function team() {
        return $this->belongsTo(Team::class, 'team_code', 'team_code');
    }

    public function classTraining() {
        return $this->belongsTo(ClassTraining::class, 'class');
    }

    public function addressTraining() {
        return $this->belongsTo(AddressesTraining::class, 'addresses');
    }

    public function presences()
    {
        return $this->hasMany(\App\Models\PresenceTraining::class, 'training_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'count_players',
        'team_code',
        'user2',
        'date',
        'start',
        'finish',
        'class',
        'addresses',
        'desc',
        'recovery',
        'load',
        'link_docs',
        'active',
        'confirmed',
        'notified',
        'notified',
        'notified_after_training',
    ];
}
