<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'team_code'   => 'nullable|string|max:20',
            'email'       => [
                'required','email','max:255',
                Rule::unique('users', 'email')->ignore($this->route('id'))
            ],
            'active'      => 'boolean',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Для user_meta
            'tel'        => 'nullable|string|max:25',
            'birthday'   => 'nullable|date',
            'position'   => 'nullable|string|max:255',
            'number'     => 'nullable|string|max:10',
            'tel_mother' => 'nullable|string|max:25',
            'tel_father' => 'nullable|string|max:25',
            'comment'    => 'nullable|string|max:255',
        ];
    }
}
