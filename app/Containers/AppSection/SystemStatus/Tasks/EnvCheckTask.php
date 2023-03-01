<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Tasks;

use App\Containers\AppSection\SystemStatus\Exceptions\EnvFailedException;
use App\Ship\Parents\Tasks\Task;

class EnvCheckTask extends Task
{
    /**
     * @psalm-return true
     */
    public function run(): bool
    {
        if (!config('systemstatus-container.services.env')) {
            return true;
        }

        $missing = [];

        $required = config('systemstatus-container.env.required');

        if (!empty($required) && \is_array($required)) {
            foreach ($required as $requiredEnv) {
                if (\is_null(env($requiredEnv))) {
                    $missing[] = $requiredEnv;
                }
            }
        }

        if (!empty($missing)) {
            $missing = implode(', ', $missing);
            throw new EnvFailedException(sprintf('Missing ENV params: %s', $missing));
        }

        return true;
    }
}
