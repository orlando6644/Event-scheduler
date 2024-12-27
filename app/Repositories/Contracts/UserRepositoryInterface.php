<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function login(array $credentials): bool;
    public function logout(): bool;
}
