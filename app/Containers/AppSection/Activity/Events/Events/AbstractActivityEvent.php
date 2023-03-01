<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Events\Events;

use App\Ship\Parents\Events\Event;
use Faker\Generator;

abstract class AbstractActivityEvent extends Event
{
    public function __construct(public int $userId, public array $data)
    {
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }

    abstract public static function getActivityHtmlString(array $data): string;

    abstract public static function seedActivity(Generator $faker, int $userId): array;
}
