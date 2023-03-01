<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class AbstractNotificationEvent implements ShouldQueue
{
    private Carbon $timestamp;

    public function __construct()
    {
        $this->timestamp = Carbon::now();
    }

    abstract public function getNotification(): string;

    abstract public function getUserId(): int;

    final public function getDateTime(): string
    {
        return $this->timestamp->toTimeString();
    }

    public function getNeedUpdate(): ?string
    {
        return null;
    }

    public function getAdditionData(): array
    {
        return [];
    }
}
