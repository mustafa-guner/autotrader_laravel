<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property mixed phone_number
 * @property mixed user_id
 * @property mixed is_verified
 * @property mixed verification_code
 * @property mixed phone_type_id
 */
class SaveMyPhoneRequest extends FormRequest
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
        $my_phone_id = $this->route('id');
        return [
            'phone_number' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'is_verified' => 'required|boolean',
            'verification_code' => 'required|string|max:255',
            'phone_type_id' => 'required|integer|exists:phone_types,id|unique:user_phones,phone_type_id,' . $my_phone_id,
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => trans('validation.required'),
            'phone_number.max' => trans('validation.max.string'),
            'user_id.required' => trans('validation.required'),
            'user_id.exists' => trans('validation.exists'),
            'is_verified.required' => trans('validation.required'),
            'phone_type_id.required' => trans('validation.required'),
            'phone_type_id.exists' => trans('validation.exists'),
            'phone_type_id.unique' => trans('validation.unique'),
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            ResponseService::fail($error, Response::HTTP_UNPROCESSABLE_ENTITY)
        );

    }
}
