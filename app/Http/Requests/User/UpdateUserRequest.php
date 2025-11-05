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

    public function rules(): array
    {
        // Получаем ID пользователя, которого мы обновляем.
        // Это можно сделать, обратившись к параметру маршрута.
        // Например, если ваш маршрут '/users/{id}', то id доступен через $this->route('id')
        $userId = $this->route('id');

        return [
            'name'        => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'second_name' => ['nullable', 'string', 'max:255'], // Возможно, это отчество
            'email'       => [
                'required',
                'string',
                'email',
                'max:255',
                // Модифицированное правило unique
                Rule::unique('users')->ignore($userId),
            ],
            'team_code'   => ['nullable', 'string', 'max:255'],
            'active'      => ['boolean'], // Добавил, если 'active' может быть в запросе
            'avatar'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Пример для аватара
            // Добавьте сюда другие правила для полей из UserMeta, если они приходят через этот реквест
            'tel'         => ['nullable', 'string', 'max:20'],
            'birthday'    => ['nullable', 'date'],
            'position'    => ['nullable', 'string', 'max:255'],
            'number'      => ['nullable', 'string', 'max:20'],
            'tel_mother'  => ['nullable', 'string', 'max:20'],
            'tel_father'  => ['nullable', 'string', 'max:20'],
            'comment'     => ['nullable', 'string'],
        ];
    }
}
