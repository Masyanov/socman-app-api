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
