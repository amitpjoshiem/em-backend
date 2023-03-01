<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Tasks;

use App\Containers\AppSection\SystemStatus\Exceptions\DatabaseFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\DB;

class DatabaseCheckTask extends Task
{
    /**
     * @psalm-return true
     */
    public function run(): bool
    {
        if (!config('systemstatus-container.services.db')) {
            return true;
        }

        try {
            DB::connection()->getDatabaseName();
        } catch (Exception $exception) {
            throw new DatabaseFailedException(previous: $exception);
        }

        return true;
    }
}
