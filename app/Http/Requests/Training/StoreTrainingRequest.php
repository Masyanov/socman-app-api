<?php
namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'team_code'             => ['required', 'max:7'],
            'date'                  => ['required', 'date'],
            'start'                 => ['required', 'string'],
            'finish'                => ['required', 'string'],
            'class'                 => ['nullable'],
            'addresses'             => ['nullable'],
            'desc'                  => ['nullable', 'string', 'max:1500'],
            'link_docs'             => ['nullable'],
            'active'                => ['nullable', 'boolean'],
            'repeat_until_checkbox' => ['nullable'],
            'repeat_until_date'     => ['nullable', 'date', 'after_or_equal:date'],
            'count_players'         => ['nullable', 'integer'],
            'recovery'              => ['nullable', 'integer'],
            'load'                  => ['nullable', 'integer'],
        ];
    }
}
