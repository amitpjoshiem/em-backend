<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;

class GetAuthenticatedUserTask extends Task
{
    public function __construct(private AuthenticatedUser $authUser)
    {
    }

    public function run(): ?UserModel
    {
        return $this->authUser->getAuthUserModel();
    }
}
