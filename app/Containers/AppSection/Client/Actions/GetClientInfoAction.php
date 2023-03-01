<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientInfoTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GetClientInfoAction extends Action
{
    public function run(): OutputClientInfoTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        return new OutputClientInfoTransporter([
            'client'    => $user->client,
            'member'    => $user->client->member,
        ]);
    }
}
