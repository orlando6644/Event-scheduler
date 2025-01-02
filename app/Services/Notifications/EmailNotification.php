<?php
namespace App\Services\Notifications;

use App\Contracts\NotificationInterface;
use Illuminate\Support\Facades\Log;

class EmailNotification implements NotificationInterface
{
    /**
     *
     * @param  mixed $data
     * @return void
     */
    public function send($data): void
    {
        //implementation of email sending
        Log::info('Email sent', $data);
        return;
    }
}
