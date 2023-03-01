<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Events\Events;

use App\Ship\Parents\Events\Event;
use Illuminate\Queue\SerializesModels;

class DeleteMemberEvent extends Event
{
    use SerializesModels;

    public function __construct(public int $id)
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
