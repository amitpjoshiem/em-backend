<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Events;

use App\Ship\Parents\Events\Event;

/**
 * Class UpdateUserDefaultProcessEvent.
 */
class UpdateUserDefaultProcessEvent extends Event
{
    /**
     * Create a new event instance.
     */
    public function __construct(public int $userId, public int $newDefaultProcessId, public ?int $oldDefaultProcessId = null)
    {
    }
}
