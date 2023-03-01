<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\User\Exceptions\UserHelperNotCreatedException;
use App\Containers\AppSection\User\Helper\UserHelper;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Core\Abstracts\Models\UserModel;

trait RealUserTrait
{
    protected function getRealUser(): User | UserModel | null
    {
        try {
            $userHelper = UserHelper::instance();

            return $userHelper->mainUser();
        } catch (UserHelperNotCreatedException) {
            try {
                return app(GetStrictlyAuthenticatedUserTask::class)->run();
            } catch (AuthenticationUserException) {
                return null;
            }
        }
    }

    protected function getStrictlyRealUser(): User | UserModel
    {
        try {
            $userHelper = UserHelper::instance();

            return $userHelper->mainUser();
        } catch (UserHelperNotCreatedException) {
            return app(GetStrictlyAuthenticatedUserTask::class)->run();
        }
    }
}
