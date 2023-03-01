<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Events;

use App\Ship\Parents\Events\Event;

class PhoneExpiredWarningEvent extends Event
{
    public function __construct(public int $userId)
    {
    }
}
