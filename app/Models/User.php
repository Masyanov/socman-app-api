<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
    public function teams(): HasMany {
        return $this->hasMany( Team::class );
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_code', 'team_code');
    }

    public function questions(): HasMany {
        return $this->hasMany( Question::class, 'user_id' );
    }

    public function settings(): HasMany {
        return $this->hasMany( SettingUser::class );
    }

    public function presence(): HasMany {
        return $this->hasMany( PresenceTraining::class );
    }

    public function meta(): HasOne {
        return $this->hasOne( UserMeta::class );
    }

    public function telegramId(): HasOne {
        return $this->hasOne( TelegramToken::class );
    }

    /**
     * Get the achievement types that this user (coach) manages.
     * Получить типы достижений, которыми управляет этот пользователь (тренер).
     */
    public function achievementTypes(): BelongsToMany
    {
        // Здесь 'user_id' в pivot-таблице 'achievement_type_user' будет означать ID тренера
        return $this->belongsToMany(AchievementType::class, 'achievement_type_user', 'user_id', 'achievement_type_id')
                    ->withTimestamps();
    }

    /**
     * Get the player achievements for this user (player).
     * Получить записи достижений для этого пользователя (игрока).
     */
    public function playerAchievements(): HasMany
    {
        return $this->hasMany(PlayerAchievement::class);
    }


    /**
     * Get all tests associated with the user.
     */
    public function tests(): HasMany {
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
