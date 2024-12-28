<?php

namespace App\Services;

use App\Repositories\Contracts\EventRepositoryInterface;

class EventService
{
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
}
