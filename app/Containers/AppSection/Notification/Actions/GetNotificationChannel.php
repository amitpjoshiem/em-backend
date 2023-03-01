<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Notification\Tasks\GetChannelNameByUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Log;

class GetNotificationChannel extends Action
{
    public function run(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        Log::info('wss channel', ['userId' => $user->getKey()]);

        return ['channel' => app(GetChannelNameByUserTask::class)->run($user)];
    }
}
