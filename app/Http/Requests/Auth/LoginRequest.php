<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string email
 * @property string password
 */
class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|string|exists:users,email|max:255',
            'password' => 'required|string',
//            'remember_me' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => trans('validation.required', ['attribute' => 'email']),
            'email.email' => trans('validation.email', ['attribute' => 'email']),
            'email.exists' => trans('validation.exists', ['attribute' => 'email']),
            'email.max' => trans('validation.max.string', ['attribute' => 'email', 'max' => 255]),
            'password.required' => trans('validation.required', ['attribute' => 'password']),
            'password.string' => trans('validation.string', ['attribute' => 'password'])
        ];
    }
}
