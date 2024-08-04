<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'require|string|max:255',
            'lastname' => 'require|string|max:255',
            'email' => 'require|string|email|max:255|unique:users',
            'username' => 'require|string|max:255|unique:users',
            'country_id' => 'require|integer|exists:countries,id',
            'gender_id' => 'require|integer|exists:genders,id',
            'password' => 'require|string|min:8|confirmed',
        ];
    }
}
