<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingUser extends Model
{
    use HasFactory;

    protected $table = 'setting_users';

    protected $fillable = [
        'user_id',
        'slug',
        'value',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
