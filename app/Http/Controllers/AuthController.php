<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Transformers\UserSessionTransformer;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private LoginService $loginService,
        private UserSessionTransformer $userSessionTransformer,
    ) {}
    /**
     * Login user
     * we will use the cookie based authentication, instead of the token based authentication.
     *
     * The uses of token based authentication would make the api stateless, but the requirements
     * includes the use of Sanctum, so we will use the cookie based authentication.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$this->loginService->login($credentials)) {
            return ApiResponse::error('Invalid credentials', [], 401);
        }

        $request->session()->regenerate();

        return ApiResponse::success([
            'user' => $this->userSessionTransformer->transform(Auth::user()),
        ]);
    }

    /**
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->loginService->logout();

            return ApiResponse::success(['message' => 'Logged out successfully']);
        } catch (\Throwable $th) {
            return ApiResponse::error('An error has occurred', [], 500);
        }
    }
}
