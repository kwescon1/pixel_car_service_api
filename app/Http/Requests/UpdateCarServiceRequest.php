<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        // Get the CarService id from the route (assuming {car_service} is used as the route parameter)
        $carServiceId = $this->route('car_service');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('car_services', 'name')->ignore($this->route('car_service'), 'uuid')
            ],
            'description' => 'nullable|string|max:1000',
            'service_type_id' => [
                'required',
                'integer',
                'exists:service_types,id',
            ],
            'price' => [
                'required',
                'numeric',
                'min:1',
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
            'name.required' => __('app.service_type_name_required'),
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
}
