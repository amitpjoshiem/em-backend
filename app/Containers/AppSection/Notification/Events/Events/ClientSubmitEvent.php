<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

class ClientSubmitEvent extends AbstractNotificationEvent
{
    public function __construct(
        private int $userId,
        private string $hashedMemberId,
        private string $clientName,
    ) {
        parent::__construct();
    }

    public function getNotification(): string
    {
        $url = sprintf(config('appSection-notification.member_details_printf_url'), config('app.frontend_url'), $this->hashedMemberId);

        return sprintf("<p>Client <a href='%s'>%s</a> submit his info</p>", $url, $this->clientName);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
