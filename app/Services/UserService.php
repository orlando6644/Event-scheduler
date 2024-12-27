<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    /**
     * Inject the UserRepositoryInterface to the UserService
     * in order to follow the dependency inversion principle.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     *
     * @param  array $credentials
     * @return bool
     */
    public function login(array $credentials): bool
    {
        return $this->userRepository->login($credentials);
    }

    /**
     *
     * @return bool
     */
    public function logout(): bool
    {
        return $this->userRepository->logout();
    }
}
