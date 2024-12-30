<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class EventRepository implements EventRepositoryInterface
{
    public CONST SORT_FIELD_MAP = [
        'recent' => 'created_at',
        'upcoming' => 'start_date',
    ];
    /**
     *
     * @param  array $data
     * @return array
     */
    public function create(array $data): array
    {
        $data['user_id'] = auth()->id();

        $event = Event::create($data);

        return Event::with('user')->find($event->id)->toArray();
    }

    /**
     *
     * @param  int $perPage
     * @param  string $sortBy
     * @return Paginator
     */
    public function getAll(int $perPage = 10, $sortBy = ''): Paginator
    {
        return Event::with('user')
        ->orderBy($this->mapSortBy($sortBy), 'desc')
        ->paginate($perPage);
    }

    /**
     *
     * @param  int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return Event::with('user')->findOrFail($id)->toArray();
    }

    /**
     * only the owner of the event can update it
     *
     * @param  array $data
     * @param  int $id
     * @return array
     */
    public function update(array $data, int $id): array
    {
        $event = Event::with('user')->findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            throw new \Exception("You are not authorized to update this event.");
        }

        $event->update($data);

        return $event->toArray();
    }

    /**
     *
     * @param  string $sortBy
     * @return string
     */
    private function mapSortBy(string $sortBy): string
    {
        return self::SORT_FIELD_MAP[$sortBy] ?? 'created_at';
    }
}
