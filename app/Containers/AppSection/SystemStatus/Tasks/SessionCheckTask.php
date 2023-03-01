<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Tasks;

use App\Containers\AppSection\SystemStatus\Exceptions\SessionFailedException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SessionCheckTask extends Task
{
    /**
     * @psalm-return true
     */
    public function run(): bool
    {
        if (!config('systemstatus-container.services.session')) {
            return true;
        }

        $key   = Str::random(32);
        $value = Str::random(4);
        Session::put($key, $value);

        if (Session::get($key) !== $value) {
            throw new SessionFailedException();
        }

        return true;
    }
}
