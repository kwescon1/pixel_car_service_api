<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class UpdateMechanicRequest extends BaseMechanicRequest
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('mechanics', 'email')->ignore($this->route('mechanic'), 'uuid')
            ],
            'phone_number' => 'required|string|max:15',
            'years_of_experience' => 'required|integer|min:0',
            'specialty' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Optional image file
            'is_active' => 'boolean',
        ];
    }
}
