<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

abstract class BaseMechanicRequest extends FormRequest
{
    /**
     * Sanitize the input data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->input('name')),
            'email' => strtolower(trim($this->input('email'))),
            'phone_number' => trim($this->input('phone_number')),
        ]);
    }

    /**
     * Get the uploaded image from the request, if available and validated.
     *
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        if ($this->hasFile('image') && array_key_exists('image', $this->validated())) {
            return $this->file('image');
        }

        return null;
    }
}
