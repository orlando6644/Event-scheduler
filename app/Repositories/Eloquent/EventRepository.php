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

        return Event::create($data)->toArray();
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
     * @param  string $sortBy
     * @return string
     */
    private function mapSortBy(string $sortBy): string
    {
        return self::SORT_FIELD_MAP[$sortBy] ?? 'created_at';
    }
}
