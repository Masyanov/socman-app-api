
@props(['checked' => false])


    <input type="checkbox" {{ $attributes->merge([
        'value' => 1,
        'checked' => !! old($attributes->get('name'), $checked),
    ]) }} class="form-check-input" id="">

