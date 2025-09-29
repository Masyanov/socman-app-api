<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresenceTraining extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'training_id',
        'user_id',
        'team_code',
    ];

    protected $dates = ['deleted_at'];
}
