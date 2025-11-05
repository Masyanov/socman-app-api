<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    public function coaches()
    {
        return $this->belongsToMany(User::class, 'admin_coach', 'admin_id', 'coach_id')
                    ->where('role', 'coach')
                    ->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'admin_coach', 'coach_id', 'admin_id')
                    ->where('role', 'admin')
                    ->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function teams() {
        return $this->hasMany( Team::class );
    }

    public function questions() {
        return $this->hasMany( Question::class, 'user_id' );
    }

    public function settings() {
        return $this->hasMany( SettingUser::class );
    }

    public function presence() {
        return $this->hasMany( PresenceTraining::class );
    }

    public function meta() {
        return $this->hasOne( UserMeta::class );
    }

    public function telegramId() {
        return $this->hasOne( TelegramToken::class );
    }

    /**
     * Get all tests associated with the user.
     */
    public function tests() {
        return $this->hasMany( PlayerTest::class );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'second_name',
        'last_name',
        'role',
        'team_code',
        'email',
        'password',
        'active',
        'load_control',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];
}
