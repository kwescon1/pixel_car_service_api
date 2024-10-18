<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingDateRequest extends FormRequest
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
            'date' => [
                'required',
                'date',
                'after:' . now()->addWeek()->format('Y-m-d'), // Ensure the date is at least 1 week ahead
                Rule::unique('booking_dates', 'date')->ignore($this->route('available_date'), 'uuid'),
            ],
            'is_active' => 'boolean',
        ];
    }
}
