<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ensure that the user is authenticated and is an admin
        return Auth::check() && Auth::user()->is_admin;
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
                Rule::unique('car_services', 'name')->ignore($this->route('car_service'), 'uuid')
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',

            'service_type_id' => [
                'required',
                'uuid',
                Rule::exists('service_types', 'uuid'),
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('app.car_service_name_required'),
            'name.unique' => __('app.car_service_name_unique'),
            'description.max' => __('app.service_name_max_description'),
            'service_type_id.required' => __('app.service_type_id_required'),
            'service_type_id.exists' => __('app.service_type_id_invalid'),
            'price.required' => __('app.price_required'),
            'price.numeric' => __('app.price_numeric'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Sanitize the inputs before validation
        $this->merge($this->sanitize());

        logger()->info('UpdateCarServiceRequest Data:', $this->all());
    }

    /**
     * Sanitize input by trimming and modifying name capitalization.
     *
     * @return array
     */
    public function sanitize(): array
    {
        return [
            'name' => ucfirst(trim($this->input('name'))),
            'description' => trim($this->input('description')),
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        logger()->error('Validation failed:', $validator->errors()->toArray());
        logger()->info('Request data:', $this->all());

        parent::failedValidation($validator);
    }
}
