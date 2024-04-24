<?php

use App\Models\ClassTraining;
use App\Models\PresenceTraining;
use App\Models\Team;
use App\Models\Training;
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
    foreach ($value as $v) {
        $countArray++;
    }
    if ($countArray < 1) {
        return false;
    } else {
        return true;
    }
}

function countPlayers($team_code)
{
    $usersOfTeamCount = User::query()
        ->where('active', true)
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

function playerTeam($team_code)
{
    $yourTeam = Team::where('team_code', $team_code)->first();

    if (isset($yourTeam)) {
        return $yourTeam->name;
    } else {
        return 'Неизвестна. Видимо у вас не верный код команды. Напишите своему тренеру чтобы исправить ошибку';
    }
}

function CountPlaerOfTeam($team_code)
{
    $usersOfTeam = User::query()
        ->where('team_code', $team_code)
        ->latest('created_at')
        ->paginate(1000);

    if (isset($usersOfTeam)) {
        return $usersOfTeam;
    } else {
        return 'НЕТ';
    }
}

function PlayerOfTeam($team_code)
{
    $usersOfTeam = User::query()
        ->where('team_code', $team_code)
        ->where('active', true)
        ->latest('created_at')
        ->paginate(1000);

    if (isset($usersOfTeam)) {
        return $usersOfTeam;
    } else {
        return 'НЕТ';
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
function pluralTrainings($number)
{
    if ($number % 10 == 1 && $number % 100 != 11) {
        return __('messages.тренировка');
    } else {
        if ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
            return __('messages.тренировки');
        } else {
            return __('messages.тренировок');
        }
    }
}

function dayOfDate($date)
{
    $days = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
    $day = $days[date("w", strtotime($date))];
    return $day;
}

function nameClass($id)
{
    $nameClass = ClassTraining::where('id', $id)->first()->name;
    return $nameClass;
}

function dateFormatYMD($value)
{
    return \Carbon\Carbon::parse($value)->format('Y-m-d');
}

function dateFormatDM($value)
{
    return \Carbon\Carbon::parse($value)->format('d.m');
}

function timeFormatHI($value)
{
    return \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i');
}

function timeTo($start, $finish)
{
    $s = strtotime($start);
    $f = strtotime($finish);
    $i = ($f - $s);
    return ceil($i / 60);
}

function trainingToday()
{
    $userId = Auth::user()->id;
    $today = date('Y-m-d');
    $find = Training::where('user_id', $userId)->where('date', $today)->first();

    if (isset($find)) {
        $value = true;
    } else {
        $value = false;
    }
    return $value;
}

function presenceOfTraining($id)
{
    $presence = PresenceTraining::query()
        ->where('training_id', $id)
        ->latest('created_at')
        ->paginate(1000);

    if (isset($presence)) {
        $presence;
    } else {
        false;
    }

    return $presence;

}

function presence($id)
{
    $presence = PresenceTraining::query()
        ->where('training_id', $id)
        ->latest('created_at')
        ->count();

    $find = Training::where('id', $id)->where('active', true)->first();

    $countPlayers = countPlayers($find->team_code);

    $percent = ($presence / $countPlayers) * 100;

    return round($percent, 0).'% ('.$presence.'/'.$countPlayers.')';
}

function presenceCheck($id)
{
    $presence = PresenceTraining::query()
        ->where('training_id', $id)
        ->latest('created_at')
        ->count();

    return $presence;
}


function freeNumber($team_code)
{
    $numbers = [];
    for ($i = 0; $i <= 98; $i++) {
        $numbers[] = $i + 1;
    }

    $usersOfTeam = User::query()
        ->where('team_code', $team_code)
        ->latest('created_at')
        ->paginate(1000);

    $playerNumber = [];
    foreach ($usersOfTeam as $player) {
        array_push($playerNumber, $player->meta->number);
    }

    $freeNumber = [];
    foreach ($numbers as $number) {
        if (!in_array($number, $playerNumber)) {
            array_push($freeNumber, $number);
        }
    }

    return $freeNumber;

}

function allTrainingCount()
{
    $userId = Auth::user()->id;
    $trainings = Training::query()
        ->where('user_id', $userId)
        ->where('confirmed', true)
        ->latest('created_at')
        ->count();

    return $trainings;
}
