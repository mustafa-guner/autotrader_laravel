<?php

namespace App\Http\Requests;

use App\Rules\ExpirationDate;
use App\Services\ResponseService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SavePaymentMethodRequest
 * @package App\Http\Requests
 * @property int card_number
 * @property string card_holder
 * @property string expiration_date
 * @property int cvv
 */
class SavePaymentMethodRequest extends FormRequest
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
            'card_number' => [
                'required',
                'integer',
                'digits:16',
                Rule::unique('payment_methods')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'card_holder' => 'required|string',
            'expiration_date' => [
                'required',
                new ExpirationDate(),
            ],
            'cvv' => 'required|integer|digits:3',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            ResponseService::fail($error, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    public function messages(): array
    {
        return [
            'card_number.unique' => 'You have already added this card before.',
        ];
    }
}
