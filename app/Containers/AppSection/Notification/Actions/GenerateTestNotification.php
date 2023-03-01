<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Notification\Events\Events\TestNotificationEvent;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GenerateTestNotification extends Action
{
    public function run(): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        event(new TestNotificationEvent($user->getKey()));
    }
}
