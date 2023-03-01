<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Tasks;

use App\Containers\AppSection\SystemStatus\Exceptions\CacheFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CacheCheckTask extends Task
{
    /**
     * @psalm-return true
     */
    public function run(): bool
    {
        if (!config('systemstatus-container.services.cache')) {
            return true;
        }

        try {
            $key   = Str::random(32);
            $value = Str::random(4);

            Cache::put($key, $value, config('systemstatus-container.cache.ttl'));

            if (Cache::get($key) !== $value) {
                throw new CacheFailedException();
            }
        } catch (Exception $exception) {
            throw new CacheFailedException($exception->getMessage(), previous: $exception);
        }

        return true;
    }
}
