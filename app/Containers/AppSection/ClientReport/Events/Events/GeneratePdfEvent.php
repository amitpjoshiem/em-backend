<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Events\Events;

use App\Ship\Parents\Events\Event;
use Illuminate\Queue\SerializesModels;

class GeneratePdfEvent extends Event
{
    use SerializesModels;

    public function __construct(public int $clientReportDocId, public array $contracts)
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
