<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Jobs;

use App\Containers\AppSection\Admin\Tasks\AdminTransferUserTask;
use App\Containers\AppSection\Notification\Events\Events\UserDeletingNotificationEvent;
use App\Ship\Parents\Jobs\Job;
use Illuminate\Support\Facades\Cache;

class TransferFromDeletedUserJob extends Job
{
    public function __construct(protected int $from, protected int $to, protected int $authUser)
    {
    }

    public function handle(): void
    {
        app(AdminTransferUserTask::class)->run($this->from, $this->to);

        $key = sprintf(config('appSection-user.user_status_key'), $this->from);
        Cache::forget($key);
        event(new UserDeletingNotificationEvent($this->authUser));
    }
}
