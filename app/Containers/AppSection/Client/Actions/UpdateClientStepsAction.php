<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\SaveClientStepsTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Client\Tasks\SaveClientTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class UpdateClientStepsAction extends Action
{
    public function run(SaveClientStepsTransporter $input): Client
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        return app(SaveClientTask::class)->run($user->getKey(), $user->client->member->getKey(), $input->toArray());
    }
}
