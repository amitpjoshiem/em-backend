<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Jobs;

use App\Containers\AppSection\Admin\Tasks\AdminRestoreTransferUserTask;
use App\Containers\AppSection\Notification\Events\Events\UserRestoredNotificationEvent;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Jobs\Job;
use Illuminate\Support\Facades\Cache;

class TransferRestoredUserJob extends Job
{
    public function __construct(protected int $restoredId, protected int $authUser)
    {
    }

    public function handle(): void
    {
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($this->restoredId);

        app(AdminRestoreTransferUserTask::class)->run($user->getKey());

        $key = sprintf(config('appSection-user.user_status_key'), $this->restoredId);
        Cache::forget($key);
        event(new UserRestoredNotificationEvent($this->authUser));
    }
}
