<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name'      => [ 'required', 'string', 'max:255' ],
            'last_name' => [ 'required', 'string', 'max:255' ],
            'role'      => [ 'required', 'string', 'max:255' ],
            'team_code' => [ 'required', 'string', 'min:7', 'exists:teams,team_code' ],
            'email'     => [ 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email' ],
            'password'  => [ 'required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults() ],
        ];
    }
}
