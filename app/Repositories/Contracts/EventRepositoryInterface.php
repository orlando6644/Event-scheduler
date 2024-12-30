<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

interface EventRepositoryInterface
{
    public function create(array $data): array;
    public function getAll(int $perPage, string $sortBy): Paginator;
}
