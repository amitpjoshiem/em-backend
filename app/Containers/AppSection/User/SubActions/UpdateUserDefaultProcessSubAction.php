<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\SubActions;

use App\Containers\AppSection\User\Events\Events\UpdateUserDefaultProcessEvent;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\SubAction;

class UpdateUserDefaultProcessSubAction extends SubAction
{
    /**
     * @throws InternalErrorException|NotFoundException
     */
    public function run(int $userId, ?int $oldDefaultProcessId, int $newDefaultProcessId): void
    {
        // Add default Process to user
        app(UpdateUserTask::class)->run(['default_process_id' => $newDefaultProcessId], $userId);

        // If this is the first added Process by default then there is no need to start this flow
        if ($oldDefaultProcessId !== null) {
            event(new UpdateUserDefaultProcessEvent(
                $userId,
                $newDefaultProcessId,
                $oldDefaultProcessId
            ));
        }
    }
}
