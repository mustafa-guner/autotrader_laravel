<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use App\Rules\ExpirationDate;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class DepositRequest
 * @package App\Http\Requests
 * @property int amount
 * @property int card_number
 * @property string card_holder
 * @property string expiration_date
 * @property int cvv
 */
class DepositRequest extends FormRequest
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
            'payment_method_id' => 'required_without_all:card_number|integer|exists:payment_methods,id',
            'amount' => 'required|integer|min:1',
            'card_number' => 'nullable|integer|digits:16|required_without:payment_method_id',
            'card_holder' => 'nullable|string|required_without:payment_method_id',
            'expiration_date' => [
                'nullable',
                'required_without:payment_method_id',
                new ExpirationDate(),
            ],
            'cvv' => 'nullable|integer|digits:3|required_without:payment_method_id',
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
