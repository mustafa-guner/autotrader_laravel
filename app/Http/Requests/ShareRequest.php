<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property int quantity
 * @property string exchange
 * @property string action_type
 * @property int price
 * @property string symbol
 *
 */
class ShareRequest extends FormRequest
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
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'exchange' => 'required|string',
            'action_type' => 'required|string',
            'price' => 'required|integer',
            'symbol' => 'required|string' //company symbol
        ];
    }
}
