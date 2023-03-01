<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Handlers;

use App\Containers\AppSection\Notification\Events\Events\AbstractNotificationEvent;
use App\Containers\AppSection\Notification\Tasks\GetChannelNameByUserTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelCentrifugo\Services\CentrifugoService;

class NotificationEventHandler implements ShouldQueue
{
    public ?string $queue = 'notifications';

    public function __construct(protected CentrifugoService $service)
    {
    }

    public function handle(AbstractNotificationEvent $event): void
    {
        $user    = app(FindUserByIdTask::class)->run($event->getUserId());

        if ($user !== null) {
            $channel = app(GetChannelNameByUserTask::class)->run($user);

            $this->service->publish($channel, [
                'notification'  => $event->getNotification(),
                'datetime'      => $event->getDateTime(),
                'need_update'   => $event->getNeedUpdate(),
                'addition_data' => $event->getAdditionData(),
            ]);
        }
    }
}
