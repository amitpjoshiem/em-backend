<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Events\Events;

use App\Ship\Parents\Events\Event;
use Illuminate\Queue\SerializesModels;

class UploadClientDocEvent extends Event
{
    use SerializesModels;

    public function __construct(public int $member_id, public int $media_id)
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
