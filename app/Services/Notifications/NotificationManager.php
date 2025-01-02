<?php
namespace App\Services\Notifications;

use App\Contracts\NotificationInterface;

class NotificationManager
{
    protected array $notifiers = [];

    public function addNotifier(NotificationInterface $notifier): void
    {
        $this->notifiers[] = $notifier;
    }

    public function sendNotifications($data): void
    {
        foreach ($this->notifiers as $notifier) {
            $notifier->send($data);
        }
    }
}
