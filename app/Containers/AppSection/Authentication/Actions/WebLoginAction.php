<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Contracts\AuthenticatedModel;
use App\Containers\AppSection\Authentication\Data\Transporters\WebLoginTransporter;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\Tasks\CheckIfUserEmailIsConfirmedTask;
use App\Containers\AppSection\Authentication\Tasks\ExtractLoginCustomAttributeTask;
use App\Containers\AppSection\Authentication\Tasks\WebLoginTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Auth\Authenticatable;

class WebLoginAction extends Action
{
    public function run(WebLoginTransporter $data): Authenticatable
    {
        $loginAttr = app(ExtractLoginCustomAttributeTask::class)->run($data);

        $isSuccessful = app(WebLoginTask::class)->run(
            $loginAttr->username,
            $data->password,
            $loginAttr->loginAttribute,
            $data->remember_me,
        );

        if ($isSuccessful === false) {
            throw new LoginFailedException();
        }

        $authUser = app(AuthenticatedModel::class)->getAuthUserModel();

        if ($authUser === null) {
            throw new LoginFailedException();
        }

        $isUserConfirmed = app(CheckIfUserEmailIsConfirmedTask::class)->run($authUser);

        if (!$isUserConfirmed) {
            throw new UserNotConfirmedException();
        }

        return $authUser;
    }
}
