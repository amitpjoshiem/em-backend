<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Events;

use App\Ship\Parents\Events\Event;

class ApiLogoutEvent extends Event
{
    public function __construct(public int $userId, public string $tokenId)
    {
    }
}
