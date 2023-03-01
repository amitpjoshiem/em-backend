<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Events;

use App\Ship\Parents\Events\Event;

class SalesforceCreateChildOpportunityEvent extends Event
{
    public function __construct(public int $childOpportunityId)
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
