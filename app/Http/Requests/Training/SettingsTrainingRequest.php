<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class SettingsTrainingRequest extends FormRequest
{
    public function authorize()
    {
        // Можно добавить проверку доступа, если нужно
        return true;
    }

    public function rules()
    {
        return [
            'classification_names'   => ['required', 'array', 'min:1'],
            'classification_names.*' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'classification_names.required' => 'Поле с классификациями обязательно.',
            'classification_names.array' => 'Неверный формат данных для классификаций.',
            'classification_names.*.required' => 'Название классификации обязательно.',
            'classification_names.*.string' => 'Название классификации должно быть строкой.',
            'classification_names.*.max' => 'Максимальная длина названия — 255 символов.',
        ];
    }
}
