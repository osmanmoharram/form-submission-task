<?php

namespace App\Http\Requests;

use App\Exceptions\DuplicateEntryException;
use App\Models\FormSubmit;
use Illuminate\Foundation\Http\FormRequest;

class FormSubmitRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'dob' => 'required|date|before:' . today()->subYears(16)->startOfYear()->toDateString(),
            'gender' => 'required|string|in:male,female',
            'nationality' => 'required|string|exists:nationalities,name',
            'cv' => 'required|file|mimes:pdf|max:2048'
        ];
    }

    public function attributes(): array
    {
        return [
            'dob' => 'Date of birth'
        ];
    }

    public function messages(): array
    {
        return [
            'dob.before' => 'You must be older the 16 to submit your form'
        ];
    }
}
