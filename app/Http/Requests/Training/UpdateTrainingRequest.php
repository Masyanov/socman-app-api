<?php


namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrainingRequest extends FormRequest {
    public function authorize() {
        // Делай проверку доступа если нужна, или просто true
        return true;
    }

    public function rules() {
        return [
            'trainingId'    => [ 'required', 'integer', 'exists:trainings,id' ],
            'team_code'     => [ 'required', 'max:7' ],
            'date'          => [ 'required', 'date' ],
            'start'         => [ 'required', 'string' ],
            'finish'        => [ 'required', 'string' ],
            'class'         => [ 'nullable', 'integer', 'exists:class_trainings,id' ],
            'addresses'     => [ 'nullable', 'integer', 'exists:addresses_trainings,id' ],
            'desc'          => [ 'nullable', 'string', 'max:1500' ],
            'link_docs'     => [ 'nullable', 'string', 'max:255' ],
            'active'        => [ 'nullable', 'boolean' ],
            'confirmed'     => [ 'nullable', 'boolean' ],
            'count_players' => [ 'nullable', 'integer', 'min:0' ],
            'recovery'      => [ 'nullable', 'integer', 'min:0' ],
            'load'          => [ 'nullable', 'integer', 'min:0' ],
            'users'         => [ 'nullable', 'array' ],
            'users.*'       => [ 'integer', 'exists:users,id' ],
        ];
    }
}
