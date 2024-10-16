<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SaveAnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', $this->route('announcement'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|url',
            'is_published' => 'required|boolean',
        ];
    }

    public function afterValidation(): SaveAnnouncementRequest
    {
        return $this->merge([
            'created_by' => $this->user()->id,
            'updated_by' => $this->user()->id,
            'published_by' => $this->user()->id,
            'published_at' => now(),
        ]);
    }

    public function messages(): array
    {
        return [
            'title.required' => trans('validation.required'),
            'title.max' => trans('validation.max.string', ['attribute' => 'title', 'max' => 255]),
            'content.required' => trans('validation.required'),
            'thumbnail.url' => trans('validation.url', ['attribute' => 'thumbnail']),
            'is_published' => trans('validation.required')
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
