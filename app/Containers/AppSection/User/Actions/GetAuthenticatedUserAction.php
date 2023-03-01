<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\UserModel;

class GetAuthenticatedUserAction extends Action
{
    public function __construct(private AuthenticatedUser $authUser)
    {
    }

    public function run(): UserModel
    {
        $user = $this->authUser->getAuthUserModel();

        if ($user === null) {
            throw new NotFoundException();
        }

        return $user;
    }
}
