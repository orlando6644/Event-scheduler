<?php

namespace App\Services;

use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class EventService
{
    private const PER_PAGE = 10;

    public function __construct(
        private EventRepositoryInterface $eventRepository
    ){}
    /**
     *
     * @param  array $data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->eventRepository->create($data);
    }

    /**
     * Get all events
     * Users will be able to view all events
     *
     * @return Paginator
     */
    public function getAll(): Paginator
    {
        return $this->eventRepository->getAll((int)self::PER_PAGE);
    }

}
