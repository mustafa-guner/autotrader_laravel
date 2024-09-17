<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveCompanyRequest
 * @package App\Http\Requests
 * @property string $name
 * @property string $description
 * @property string|null $website
 *
 */
class SaveCompanyRequest extends FormRequest
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
            'website' => 'nullable|max:255|url',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('validation.required'),
            'name.max' => trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            'description.required' => trans('validation.required'),
            'description.max' => trans('validation.max.string', ['attribute' => 'description', 'max' => 255]),
            'website.max' => trans('validation.max.string', ['attribute' => 'website', 'max' => 255]),
            'website.url' => trans('validation.url', ['attribute' => 'website']),
        ];
    }
}
