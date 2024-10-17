<?php


namespace App\Http\Requests;


class StoreMechanicRequest extends BaseMechanicRequest
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
            'email' => 'required|email|unique:mechanics,email',
            'phone_number' => 'required|string|max:15',
            'years_of_experience' => 'required|integer|min:0', // Minimum years of experience
            'speciality' => 'nullable|string', // Minimum years of experience
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Image file, max 2MB
            'is_active' => 'boolean',  // Whether the mechanic is active
        ];
    }
}
