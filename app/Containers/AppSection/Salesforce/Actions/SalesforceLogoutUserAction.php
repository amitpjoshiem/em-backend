<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Salesforce\Tasks\SalesforceDeleteUserTask;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Actions\Action;

class SalesforceLogoutUserAction extends Action
{
    /**
     * @throws AuthenticationUserException|DeleteResourceFailedException
     */
    public function run(): void
    {
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        app(SalesforceDeleteUserTask::class)->run($user->getKey());
    }
}
