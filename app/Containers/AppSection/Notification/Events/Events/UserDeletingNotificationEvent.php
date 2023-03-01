<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

class UserDeletingNotificationEvent extends AbstractNotificationEvent
{
    public function __construct(private int $userId)
    {
        parent::__construct();
    }

    public function getNotification(): string
    {
        return '<p>User Successfully Deleted</p>';
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNeedUpdate(): ?string
    {
        return 'admin_panel_users';
    }
}
