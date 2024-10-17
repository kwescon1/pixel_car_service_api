<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingDateRequest extends FormRequest
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
                'after:' . now()->addWeek()->format('Y-m-d'),
                Rule::unique('booking_dates', 'date')->where(function ($query) {
                    return $query->where('is_active', true); // Ensure no duplicate active booking dates
                })
            ],
            'is_active' => 'boolean',
        ];
    }
}
