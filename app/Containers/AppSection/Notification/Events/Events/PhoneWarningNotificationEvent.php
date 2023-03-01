<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

class PhoneWarningNotificationEvent extends AbstractNotificationEvent
{
    public function __construct(private int $userId, private string $expireDate)
    {
        parent::__construct();
    }

    public function getNotification(): string
    {
        return sprintf('<p>Your Phone validation will expire %s </p>', $this->expireDate);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
