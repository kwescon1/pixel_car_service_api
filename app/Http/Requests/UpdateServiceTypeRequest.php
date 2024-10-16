<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_types', 'name')->ignore($this->route('service_type'), 'uuid'), // Ignore the current service type being updated
            ],
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('app.service_type_name_required'),
            'name.unique' => __('app.service_name_unique'),
            'description.max' => __('app.service_name_max_description'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Automatically sanitize inputs before validation
        $this->merge($this->sanitize());
    }

    /**
     * Sanitize input by trimming and modifying name capitalization.
     */
    public function sanitize(): array
    {
        return [
            'name' => ucfirst(trim($this->input('name'))),
            'description' => trim($this->input('description')),
        ];
    }
}
