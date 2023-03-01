<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\SubActions;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Ship\Parents\Actions\SubAction;
use App\Ship\Parents\Models\UserModel;

class IsOwnerSubAction extends SubAction
{
    /**
     * Check if the submitted ID (mainly URL ID's) is the same as
     * the authenticated user ID (based on the user Token).
     */
    public function run(?int $userId = null): bool
    {
        $user = app(GetAuthenticatedUserTask::class)->run();

        return !empty($userId) && $user instanceof UserModel && $user->getKey() === $userId;
    }
}
