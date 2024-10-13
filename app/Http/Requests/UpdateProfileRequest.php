<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest
 * @package App\Http\Requests
 * @property string old_password
 * @property string new_password
 * @property int country_id
 * @property int gender_id
 */
class UpdateProfileRequest extends FormRequest
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
            'old_password' => [
                'nullable',
                'string',
                'min:8',
                'required_with:new_password',
                function ($attribute, $value, $fail) {
                    /**
                     * @var User $user
                     */
                    $user = Auth::user();
                    if ($user && !password_verify($value, $user->password)) {
                        $fail('The old password is incorrect.');
                    }
                },
            ],
            'new_password' => 'nullable|string|min:8|required_with:old_password',
            'country_id' => 'nullable|integer|exists:countries,id',
            'gender_id' => 'nullable|integer|exists:genders,id',
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
