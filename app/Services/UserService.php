<?php

namespace App\Services;

use App\Jobs\TelegramNotifyUserActiveChanged;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\SettingLoadcontrol;
use App\Services\AvatarService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    private AvatarService $avatarService;

    public function __construct(AvatarService $avatarService)
    {
        $this->avatarService  = $avatarService;
    }

    public function listUsers($userId) : Collection
    {
        // Example: все команды пользователя
        return User::where('id', $userId)->with('teams')->get();
    }

    public function create(array $data)
    {
        return DB::transaction(function() use ($data) {
            $user = User::create([
                'name'      => $data['name'],
                'last_name' => $data['last_name'],
                'role'      => $data['role'],
                'team_code' => $data['team_code'] ?? null,
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
            ]);

            UserMeta::create(['user_id' => $user->id]);

            if ($user->role === 'coach') {
                SettingLoadcontrol::create([
                    'user_id'               => $user->id,
                    'on_load'               => 0,
                    'on_extra_questions'    => 0,
                    'question_recovery_min' => 60,
                    'question_load_min'     => 60,
                ]);
            }

            return $user;
        });
    }

    public function get($id)
    {
        return User::with('meta', 'teams')->findOrFail($id);
    }

    public function update($id, array $data, $avatarFile = null)
    {
        return DB::transaction(function() use ($id, $data, $avatarFile) {
            $user = User::findOrFail($id);

            $user->update([
                'name'        => $data['name'],
                'second_name' => $data['second_name'] ?? null,
                'last_name'   => $data['last_name'],
                'team_code'   => $data['team_code'] ?? null,
                'email'       => $data['email'],
                'active'      => $data['active'] ?? $user->active,
            ]);

            $userMeta = $user->meta()->firstOrCreate([]);

            $avatarName = $userMeta->avatar;
            if ($avatarFile) {
                $avatarName = $this->avatarService->uploadAndOptimize($avatarFile);
            }

            $userMeta->update([
                'tel'        => $data['tel'] ?? null,
                'birthday'   => $data['birthday'] ?? null,
                'position'   => $data['position'] ?? null,
                'number'     => $data['number'] ?? null,
                'tel_mother' => $data['tel_mother'] ?? null,
                'tel_father' => $data['tel_father'] ?? null,
                'comment'    => $data['comment'] ?? null,
                'avatar'     => $avatarName,
            ]);

            return $user;
        });
    }

    public function setActive($id, $active)
    {
        $user = User::findOrFail($id);
        $oldActive = $user->active;
        $user->active = $active;

        if ($user->isDirty('active')) {
            $user->save();
            TelegramNotifyUserActiveChanged::dispatch((int) $user->id, (bool) $user->active);
        }

        return $user->active;
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            // примитивное удаление, можно сложнее/мягкое через репозитории
            UserMeta::where('user_id', $id)->delete();
            SettingLoadcontrol::where('user_id', $id)->delete();
            // ... и т.д. по вашим таблицам
            User::where('id', $id)->delete();
        });
    }
}
