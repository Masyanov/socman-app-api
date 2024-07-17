<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
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
        'user2',
        'date',
        'start',
        'finish',
        'class',
        'desc',
        'recovery',
        'load',
        'link_docs',
        'active',
        'confirmed',
    ];

}
