<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientInfoTransporter;
use App\Containers\AppSection\Client\Data\Transporters\UpdateClientTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Client\Tasks\SaveClientTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class UpdateClientAction extends Action
{
    public function run(UpdateClientTransporter $input): OutputClientInfoTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        app(SaveClientTask::class)->run($user->getKey(), $user->client->member->getKey(), $input->toArray());

        return new OutputClientInfoTransporter([
            'client'    => $user->client,
            'member'    => $user->client->member,
        ]);
    }
}
