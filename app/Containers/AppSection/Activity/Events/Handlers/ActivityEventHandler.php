<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Events\Handlers;

use App\Containers\AppSection\Activity\Events\Events\AbstractActivityEvent;
use App\Containers\AppSection\Activity\Tasks\CreateActivityTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivityEventHandler implements ShouldQueue
{
    public ?string $queue = 'activities';

    public function handle(AbstractActivityEvent $event): void
    {
        $data = [
            'user_id'       => $event->userId,
            'activity'      => $event::class,
            'activity_data' => $event->data,
        ];
        app(CreateActivityTask::class)->run($data);
    }
}
