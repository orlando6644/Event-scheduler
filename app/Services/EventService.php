<?php

namespace App\Services;

use App\Events\EventCreated;
use App\Events\EventDeleted;
use App\Events\EventUpdated;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Services\Notifications\EmailNotification;
use App\Services\Notifications\NotificationManager;
use App\Services\Notifications\SmsNotification;
use Illuminate\Contracts\Pagination\Paginator;

class EventService
{
    private const PER_PAGE = 10;

    /**
    * repository pattern has been used to interact with the database
    */
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
        $event = $this->eventRepository->create($data);

        broadcast(new EventCreated($event))->toOthers();

        return $event;
    }

    /**
     * Get all events
     * Users will be able to view all events
     *
     * @param array $data Request data
     * @return Paginator
     */
    public function getAll(array $data): Paginator
    {
        return $this->eventRepository->getAll((int)self::PER_PAGE, $data['sortBy'] ?? '');
    }

    /**
     *
     * @param  string $id
     * @return array
     */
    public function getById(string $id): array
    {
        return $this->eventRepository->getById((int)$id);
    }

    /**
     *
     * @param  array $data
     * @param  string $id
     * @return array
     */
    public function update(array $data, string $id): array
    {
        $event = $this->eventRepository->update($data, (int)$id);

        /**
         * Here we are broadcasting an event to all users except the current user.
         * This is done by calling the toOthers() method on the broadcast helper function.
         * This broadcasting could be delegated to a job or a queue to improve performance.
         */
        broadcast(new EventUpdated($event))->toOthers();

        /**
         * here's an example of how to use the NotificationManager
         * In order to send notifications, we need to create an instance of the NotificationManager class
         * and add the notifiers we want to use.
         * Factory pattern is used to create the notifiers
         */
        $notificationManager = new NotificationManager();
        $notificationManager->addNotifier(new EmailNotification());
        $notificationManager->addNotifier(new SmsNotification());

        $notificationManager->sendNotifications($event);

        return $event;
    }

    /**
     *
     * @param  string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $event = $this->eventRepository->getById((int)$id);

        $this->eventRepository->delete((int)$event['id']);

        broadcast(new EventDeleted($event))->toOthers();
    }
}
