<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Events;

use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Events\Event;

class CreateMemberFromSalesforceEvent extends Event
{
    public function __construct(public Member $member)
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
