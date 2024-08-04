<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed user_id
 * @property mixed hash
 */
class VerifyEmailRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'hash' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => trans('error.user.user_id_required'),
            'user_id.exists' => trans('error.user.user_id_not_found'),
            'hash.required' => trans('error.user.hash_required'),
        ];
    }
}
