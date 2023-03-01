<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Actions;

use App\Containers\AppSection\SystemStatus\Tasks\CacheCheckTask;
use App\Containers\AppSection\SystemStatus\Tasks\DatabaseCheckTask;
use App\Containers\AppSection\SystemStatus\Tasks\EnvCheckTask;
use App\Containers\AppSection\SystemStatus\Tasks\RedisCheckTask;
use App\Containers\AppSection\SystemStatus\Tasks\SessionCheckTask;
use App\Containers\AppSection\SystemStatus\Tasks\StorageCheckTask;
use App\Ship\Parents\Actions\Action;

class GetAllSystemStatusesAction extends Action
{
    /**
     * @psalm-return true
     */
    public function run(): bool
    {
        app(CacheCheckTask::class)->run();
        app(DatabaseCheckTask::class)->run();
        app(EnvCheckTask::class)->run();
        app(RedisCheckTask::class)->run();
        app(SessionCheckTask::class)->run();
        app(StorageCheckTask::class)->run();

        return true;
    }
}
