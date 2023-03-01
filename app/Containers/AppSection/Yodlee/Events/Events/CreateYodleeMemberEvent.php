<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Events\Events;

use App\Ship\Parents\Events\Event;

class CreateYodleeMemberEvent extends Event
{
    public function __construct(public int $memberId)
    {
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
