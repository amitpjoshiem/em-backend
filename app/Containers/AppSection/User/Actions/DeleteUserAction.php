<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Parents\Actions\Action;

class DeleteUserAction extends Action
{
    public function run(DeleteUserRequest $userData): void
    {
        $user = $userData->id !== 0 ?
          app(FindUserByIdTask::class)->run($userData->id)
            :
          app(GetAuthenticatedUserTask::class)->run();

        if ($user === null) {
            throw new UserNotFoundException();
        }

        app(DeleteUserTask::class)->run($user);
    }
}
