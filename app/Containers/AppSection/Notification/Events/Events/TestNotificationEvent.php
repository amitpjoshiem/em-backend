<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

class TestNotificationEvent extends AbstractNotificationEvent
{
    public function __construct(private int $userId)
    {
        parent::__construct();
    }

    public function getNotification(): string
    {
        return '<p>This Is Test Notification with <a href="">link</a></p>';
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
