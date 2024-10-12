<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string firstname
 * @property string lastname
 * @property string email
 * @property string dob
 * @property int country_id
 * @property int gender_id
 * @property string password
 */
class RegisterRequest extends FormRequest
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
            'dob' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'country_id' => 'required|integer|exists:countries,id',
            'gender_id' => 'required|integer|exists:genders,id',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'First name is required',
            'firstname.max' => 'First name must not be more than 255 characters',
            'lastname.required' => 'Last name is required',
            'lastname.max' => 'Last name must not be more than 255 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must not be more than 255 characters',
            'email.unique' => 'Email has already been taken',
            'dob.required' => 'Date of birth is required',
            'dob.date' => 'Date of birth must be a valid date',
            'dob.before' => 'You must be at least 18 years old to register',
            'country_id.required' => 'Country is required',
        ];
    }
}
