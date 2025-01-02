<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

/*
* in order to apply the repository pattern,
* we need to create an interface that will define the methods that will be implemented in the repository class.
*/

interface EventRepositoryInterface
{
    public function create(array $data): array;
    public function getAll(int $perPage, string $sortBy): Paginator;
    public function getById(int $id): array;
    public function update(array $data, int $id): array;
    public function delete(int $id): void;
}
