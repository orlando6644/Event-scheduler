<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

interface EventRepositoryInterface
{
    public function create(array $data): array;
    public function getAll(int $perPage, string $sortBy): Paginator;
    public function getById(int $id): array;
    public function update(array $data, int $id): array;
}
