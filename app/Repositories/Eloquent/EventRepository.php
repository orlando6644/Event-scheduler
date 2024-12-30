<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class EventRepository implements EventRepositoryInterface
{
    /**
     *
     * @param  array $data
     * @return array
     */
    public function create(array $data): array
    {
        $data['user_id'] = auth()->id();

        return Event::create($data)->toArray();
    }

    /**
     *
     * @param  int $perPage
     * @return Paginator
     */
    public function getAll(int $perPage = 10): Paginator
    {
        return Event::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
    }
}
