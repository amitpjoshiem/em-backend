<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Ship\Parents\Actions\Action;

class FindUserByEmailAction extends Action
{
    public function run(string $email): User
    {
        $user = app(FindUserByEmailTask::class)->run($email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
