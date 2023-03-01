<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Events\Events;

use App\Ship\Parents\Events\Event;
use Illuminate\Queue\SerializesModels;

class SubmitClientEvent extends Event
{
    use SerializesModels;

    public function __construct(public int $clientId)
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
