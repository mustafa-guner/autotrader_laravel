<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string firstname
 * @property string lastname
 * @property string email
 * @property int country_id
 * @property int gender_id
 * @property string password
 */
class UserRegistrationRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'country_id' => 'required|integer|exists:countries,id',
            'gender_id' => 'required|integer|exists:genders,id',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
