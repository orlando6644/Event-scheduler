<?php
namespace App\Services\Notifications;

use App\Contracts\NotificationInterface;
use Illuminate\Support\Facades\Log;

class SmsNotification implements NotificationInterface
{
    /**
     *
     * @param  mixed $data
     * @return void
     */
    public function send($data): void
    {
        //implementation of SMS sending
        Log::info('SMS sent', $data);
        return;
    }
}
