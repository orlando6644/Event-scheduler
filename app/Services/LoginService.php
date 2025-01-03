<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

/**
 * all the login related logic will be handled here
 */
class LoginService
{   /**
     *
     * @param  array $credentials
     * @return bool
     */
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    /**
     *
     * @return bool
     */
    public function logout(): bool
    {
        Auth::guard('web')->logout();
        $request = request();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return true;
    }
}
