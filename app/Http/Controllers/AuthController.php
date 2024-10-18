<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\LoginUserRequest;
use App\Interfaces\Auth\AuthServiceInterface;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }


    /**
     * Handle the user login process.
     *
     * This method processes the login request by validating the provided credentials
     * through the LoginUserRequest. If validation passes, the user's details are retrieved
     * and passed to the AuthService for token generation and any additional login logic.
     *
     * @param LoginUserRequest $request The validated login request containing the user's credentials.
     */
    public function login(LoginUserRequest $request)
    {
        // The validation process is handled within the form request.
        // Here we just retrieve the user and proceed with token generation.
        $user = $request->validatedUser();

        $results = $this->authService->login($user);


        $userResource = new UserResource($results['user']);
        $token = $results['token'];

        return response()->success(
            __('app.login_successful'),
            [
                'user' => $userResource,
                'token' => $token
            ]
        );
    }
}
