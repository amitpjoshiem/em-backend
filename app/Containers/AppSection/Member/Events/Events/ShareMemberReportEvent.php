<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Events\Events;

use App\Ship\Parents\Events\Event;

class ShareMemberReportEvent extends Event
{
    public function __construct(public array $uuids, public array $emails, public int $userId)
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
