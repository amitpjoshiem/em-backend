<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientConfirmationTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GetClientConfirmationsAction extends Action
{
    public function run(): OutputClientConfirmationTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        return app(GetClientConfirmationSubAction::class)->run($user->client);
    }
}
