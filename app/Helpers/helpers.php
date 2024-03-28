<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('CountTeam')) {

    function CountTeam()
    {
        $userId = Auth::user()->id;

        $teamActive = Team::query()
            ->where('active', true)
            ->where('user_id', $userId)
            ->paginate(10)
            ->count();

        if (isset($teamActive)) {
            return $teamActive;
        } else {
            return 'НЕТ';
        }
    }
}



function whatInArray($value)
{
    $countArray = 0;
    foreach($value as $v) {
        $countArray++;
    }
    if($countArray < 1) {
        return false ;
    } else {
        return true ;
    }
}

function countPlayers($team_code)
{
    $usersOfTeamCount = User::query()
        ->where('team_code', $team_code)
        ->latest('created_at')
        ->count();

    if (isset($usersOfTeamCount)) {
        return $usersOfTeamCount;
    } else {
        return 'Неизвестно';
    }
}
function CountPlayerOfCoach()
{
    $userId = Auth::user()->id;

    $teamActive = Team::query()
        ->where('active', true)
        ->where('user_id', $userId)
        ->paginate(10);

    $count = [];
    foreach ($teamActive as $team) {
        $count[] = countPlayers($team->team_code);
    }

    if (isset($count)) {
        return array_sum($count);
    } else {
        return 'НЕТ';
    }
}

function yourTeam()
{
    $teamCode = Auth::user()->team_code;
    $yourTeam = Team::where('team_code', $teamCode)->first();

    if (isset($yourTeam)) {
        return $yourTeam->name;
    } else {
        return 'Неизвестна. Видимо у вас не верный код команды. Напишите своему тренеру чтобы исправить ошибку';
    }


}

function pluralTeam($number)
{
    if ($number % 10 == 1 && $number % 100 != 11) {
        return __('messages.команда');
    } else {
        if ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
            return __('messages.команды');
        } else {
            return __('messages.команд');
        }
    }
}
function pluralPlayers($number)
{
    if ($number % 10 == 1 && $number % 100 != 11) {
        return __('messages.игрок');
    } else {
        if ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
            return __('messages.игрока');
        } else {
            return __('messages.игроков');
        }
    }
}
