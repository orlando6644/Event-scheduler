<?php

namespace App\Repositories\Contracts;

interface EventRepositoryInterface
{
    public function create(array $data): array;
}
