<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SaveFeedbackRequest
 * @package App\Http\Requests
 * @property int feedback_type_id
 * @property string comment
 */
class SaveFeedbackRequest extends FormRequest
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
            'feedback_type_id' => 'required|exists:feedback_types,id',
            'comment' => 'required|string|max:200',
        ];
    }

    public function messages(): array
    {
        return [
            'feedback_type_id.required' => 'Feedback type is required',
            'feedback_type_id.exists' => 'Feedback type does not exist',
            'comment.required' => 'Comment is required',
            'comment.string' => 'Comment must be a string',
            'comment.max' => 'Comment must not exceed 200 characters',
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
