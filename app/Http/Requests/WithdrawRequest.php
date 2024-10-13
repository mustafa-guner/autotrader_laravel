<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class WithdrawRequest
 * @package App\Http\Requests
 * @property int amount
 * @property int bank_account_id
 */
class WithdrawRequest extends FormRequest
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
        /**
         * @var User $user
         */

        $user = auth()->user();
        $userBalance = $user->userBalance->balance;

        return [
            'amount' => 'required|integer|min:1|max:' . $userBalance,
            'bank_account_id' => 'required|integer|exists:bank_accounts,id',
        ];
    }

    /**
     * Get the validation messages for the defined rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'amount.max' => 'You cannot withdraw more than your current balance of ' . auth()->user()->userBalance->balance . '.',
        ];
    }
}
