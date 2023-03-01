<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\SendCreatePasswordTransporter;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\SubAction;

class SendCreatePasswordAction extends SubAction
{
    public function run(SendCreatePasswordTransporter $input): void
    {
        $user = app(FindUserByIdTask::class)->run($input->id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        app(SendCreatePasswordSubAction::class)->run($user);
    }
}
