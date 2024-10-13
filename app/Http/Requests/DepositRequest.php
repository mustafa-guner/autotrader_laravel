<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DepositRequest
 * @package App\Http\Requests
 * @property int amount
 * @property int bank_account_id
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
            'bank_account_id' => 'required|integer|exists:bank_accounts,id'
        ];
    }
}
