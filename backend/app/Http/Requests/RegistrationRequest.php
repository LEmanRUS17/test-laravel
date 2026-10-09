<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            // Принимаем только значения из enum Gender (male, female)
            'gender' => ['required', Rule::enum(Gender::class)],
        ];
    }

    /**
     * Сообщения об ошибках валидации
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Введите email',
            'email.email' => 'Введите корректный email',
            'email.max' => 'Email не должен быть длиннее 255 символов',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен быть не короче 8 символов',
            'gender.required' => 'Выберите пол',
            'gender.enum' => 'Выберите пол из списка',
        ];
    }
}
