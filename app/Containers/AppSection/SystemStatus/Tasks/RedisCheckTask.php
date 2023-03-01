<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Tasks;

use App\Containers\AppSection\SystemStatus\Exceptions\RedisFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Redis\RedisManager;

class RedisCheckTask extends Task
{
    public function __construct(private RedisManager $redis)
    {
    }

    public function run(): bool
    {
        if (!config('systemstatus-container.services.redis')) {
            return true;
        }

        try {
            $pong = $this->redis->ping();
        } catch (Exception $exception) {
            throw new RedisFailedException(previous: $exception);
        }

        return (bool)$pong;
    }
}
