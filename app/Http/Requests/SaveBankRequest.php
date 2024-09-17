<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $description
 * @property mixed $swift_code
 * @property mixed $website
 * @property mixed $is_active
 */
class SaveBankRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'swift_code' => 'required|string|max:255|unique:banks,code',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('validation.required'),
            'name.max' => trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            'description.required' => trans('validation.required'),
            'description.max' => trans('validation.max.string', ['attribute' => 'description', 'max' => 255]),
            'swift_code.required' => trans('validation.required'),
            'swift_code.unique' => trans('validation.unique', ['attribute' => 'swift_code']),
        ];
    }
}
