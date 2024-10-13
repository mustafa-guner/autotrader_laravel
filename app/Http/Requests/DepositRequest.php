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
            'amount' => 'required|integer|min:1',
            'card_number' => 'required|integer|digits:16',
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
}
