<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Interfaces\Auth\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{

    /**
     * Login an existing user and generate an authentication token.
     *
     * @param User $user The authenticated user.
     * @return array An array containing the user resource and the authentication token.
     */
    public function login(User $user): array
    {
        // Clear previous tokens
        $user->tokens()->delete();

        $token = $this->generateUserToken($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }


    /**
     * Generate an authentication token for the user.
     *
     * @param User $user The user for whom the token is generated.
     * @return string The plain-text authentication token.
     */
    private function generateUserToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}
