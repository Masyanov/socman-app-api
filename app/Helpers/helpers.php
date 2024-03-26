<?php

use App\Models\Team;
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

        return $teamActive;
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

function yourTeam()
{
    $teamCode = Auth::user()->team_code;
    $yourTeam = Team::where('team_code', $teamCode)->first();

    return $yourTeam->name;
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
