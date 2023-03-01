<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Events\Handlers;

use App\Containers\AppSection\Authentication\Events\ApiLoginEvent;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Client\Tasks\UpdateClientTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckClientFirstFillInfoEventHandler implements ShouldQueue
{
    public function handle(ApiLoginEvent $event): void
    {
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($event->userId);

        if ($user->hasRole(RolesEnum::LEAD)) {
            $user = $user->load('client');

            if ($user->client->first_fill_info === null) {
                app(UpdateClientTask::class)->run($user->client->getKey(), ['first_fill_info' => now()]);
            }
        }
    }
}
