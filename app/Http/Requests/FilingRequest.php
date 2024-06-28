<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilingRequest extends FormRequest
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
            'type_id'=>'required|integer',
            'unit_id'=>'required|integer',
            'department_id'=>'required|integer',
            'user_id'=>'required|integer',
            'document_date'=>'nullable|date',
            'person_name'=>'nullable',
            'subject'=>'required|string',
            'keywords'=>'required|string',
            'location'=>'nullable',
            'room'=>'nullable',
            'cabinet'=>'nullable',
            'rack'=>'nullable',
            'box'=>'nullable',
            'folder'=>'nullable',
        ];
    }

    public function messages() : array

    {

        return [
            'type_id.required' => 'Document Type is a required field.',
            'unit_id.required' => 'Business Unit is a required field.',
            'department_id.required' => 'Department is a required field.',
            'user_id.required' => 'You are not logged in. Please log in to continue.',
            'subject.required' => 'Subject is a required field.',
            'keywords.required' => 'keywords is a required field.',

        ];

    }
}
