<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class AddressesTrainingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'addresses_names'   => ['required', 'array', 'min:1'],
            'addresses_names.*' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'addresses_names.required' => 'Поле с адресами обязательно.',
            'addresses_names.array' => 'Неверный формат данных для адресов.',
            'addresses_names.*.required' => 'Название адреса обязательно.',
            'addresses_names.*.string' => 'Название адреса должно быть строкой.',
            'addresses_names.*.max' => 'Максимальная длина названия — 255 символов.',
        ];
    }
}
