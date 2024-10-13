<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property mixed transaction_type_id
 * @property mixed transaction_status_id
 * @property mixed amount
 * @property mixed currency
 * @property mixed description
 * @property mixed transaction_by
 * @property mixed user_id
 */
class SaveTransactionRequest extends FormRequest
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
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'transaction_status_id' => 'required|exists:transaction_statuses,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'transaction_type_id.required' => trans('validation.required', ['attribute' => 'Transaction Type']),
            'transaction_type_id.exists' => trans('validation.exists', ['attribute' => 'Transaction Type']),
            'transaction_status_id.required' => trans('validation.required', ['attribute' => 'Transaction Status']),
            'transaction_status_id.exists' => trans('validation.exists', ['attribute' => 'Transaction Status']),
            'amount.required' => trans('validation.required', ['attribute' => 'Amount']),
            'description.required' => trans('validation.required', ['attribute' => 'Description']),
            'currency.required' => trans('validation.required', ['attribute' => 'Currency']),
            'user_id.required' => trans('validation.required', ['attribute' => 'User']),
            'user_id.exists' => trans('validation.exists', ['attribute' => 'User']),
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
