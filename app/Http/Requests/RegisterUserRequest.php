<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'password_confirmation' => 'required|string|min:4|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Поле "Имя" не должно превышать 255 символов.',
            'name.min' => 'Поле "Имя" должно содержать не менее 3 символов.',

            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.string' => 'Поле "Email" должно быть строкой.',
            'email.email' => 'Поле "Email" должно быть действительным адресом электронной почты.',
            'email.max' => 'Поле "Email" не должно превышать 255 символов.',
            'email.unique' => 'Такой Email уже зарегистрирован.',

            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.string' => 'Поле "Пароль" должно быть строкой.',
            'password.min' => 'Поле "Пароль" должно содержать не менее 4 символов.',
            'password.confirmed' => 'Пароли не совпадают.',

            'password_confirmation.required' => 'Поле подтверждения пароля обязательно для заполнения.',
            'password_confirmation.string' => 'Поле подтверждения пароля должно быть строкой.',
            'password_confirmation.min' => 'Поле подтверждения пароля должно содержать не менее 4 символов.',
            'password_confirmation.same' => 'Поле подтверждения пароля должно совпадать с паролем.',
        ];
    }
}
