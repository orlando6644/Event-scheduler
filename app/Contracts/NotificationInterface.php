<?php

namespace App\Contracts;

interface NotificationInterface
{
    public function send($data): void;
}
