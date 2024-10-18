<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\AuthenticationException;

class LoginUserRequest extends FormRequest
{
    // Store the user object after validation
    protected $user;

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
            "email" => "required|email|max:255",
            "password" => "required|string|max:255",
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * This method is called before the validation rules are applied.
     * It sanitizes the email input to ensure the data is in the correct format before validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'email' => trim(strtolower($this->input('email'))),
        ]);
    }

    /**
     * Retrieve the validated email input.
     *
     * This method returns the validated and sanitized email input that will be used in further processing.
     *
     * @return string
     */
    public function getSanitizedEmailInput(): string
    {
        return $this->validated()['email'];
    }

    /**
     * Retrieve the validated password input.
     *
     * This method returns the validated password from the request data.
     *
     * @return string
     */
    public function validatedPassword(): string
    {
        return $this->validated()['password'];
    }

    /**
     * Find the user by the email field.
     *
     * This method uses the email input to search for the user in the database.
     * If a user is found, it returns the user object; otherwise, it returns null.
     *
     * @return \App\Models\User|null
     */
    public function findUser(): ?User
    {
        return User::where('email', $this->getSanitizedEmailInput())->first();
    }

    /**
     * Check if the provided password matches the stored password.
     *
     * This method verifies the user's password by comparing the provided password
     * with the hashed password stored in the database.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function checkPassword(User $user): bool
    {
        return Hash::check($this->validatedPassword(), $user->password);
    }

    /**
     * Validate the user's credentials.
     *
     * This method validates the user's credentials by first finding the user and then
     * checking the password. If the user is not found or the password is incorrect,
     * it throws an authentication exception.
     *
     * @return void
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function validateUserCredentials(): void
    {
        $user = $this->findUser();

        // Check if the user exists and the password matches
        if (!$user || !$this->checkPassword($user)) {
            throw new AuthenticationException(__('auth.failed'));
        }

        // Store the validated user
        $this->user = $user;
    }

    /**
     * Get the validated user.
     *
     * This method retrieves the user object that was stored during the validation process.
     * It allows the controller to access the validated user after the credentials
     * have been validated.
     *
     * @return \App\Models\User
     */
    public function validatedUser(): User
    {
        // Validate the user's credentials before returning the user
        $this->validateUserCredentials();

        return $this->user;
    }
}
