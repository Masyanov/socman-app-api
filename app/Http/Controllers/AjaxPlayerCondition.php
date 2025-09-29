<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxPlayerCondition extends Controller {
    public function ajaxCondition( Request $request ) {
        $id = (int) $request->input( 'user_id' );
        $dateAnswer = $request->input( 'dateAnswer' );

        // Тут логика выборки данных пользователя
        $user = User::find( $id );
        $name = $user ? $user->name : "Неизвестно";
        $last_name = $user ? $user->last_name : "Неизвестно";

        $answerCurrent = Question::where('user_id', $id)->whereDate('created_at', $dateAnswer)->first();

        $recovery = $answerCurrent->recovery ?? 0;
        $pain = $answerCurrent->pain ?? 0;
        $sleep = $answerCurrent->sleep ?? 0;
        $moral = $answerCurrent->moral ?? 0;
        $physical = $answerCurrent->physical ?? 0;

        $generalCondition = (( (int) $recovery + (int) $sleep + (int) $moral + (int) $physical ) - (int) $pain) / 4;

        $data = [
            'pain'              => conditionPlayerIndicate($answerCurrent->pain * 10 ?? 0, 'low', 30, 60), // lower is better
            'local'             => $answerCurrent->local ?? 'Нет',
            'sleep'             => conditionPlayerIndicate($answerCurrent->sleep * 10 ?? 0, 'high', 70, 40), // higher is better
            'sleep_time'        => $answerCurrent->sleep_time ?? 'Нет',
            'moral'             => conditionPlayerIndicate($answerCurrent->moral * 10 ?? 0, 'high', 70, 40),
            'physical'          => conditionPlayerIndicate($answerCurrent->physical * 10 ?? 0, 'high', 70, 40),
            'general-condition' => conditionPlayerIndicate($generalCondition * 10 ?? 0, 'high', 70, 40),
        ];

        return response()->json( [
            'name' => $name,
            'last_name' => $last_name,
            'data' => $data
        ] );
    }
}
