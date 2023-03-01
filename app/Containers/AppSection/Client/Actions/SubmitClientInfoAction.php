<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authentication\Tasks\LogoutUserTask;
use App\Containers\AppSection\Client\Events\Events\SubmitClientEvent;
use App\Containers\AppSection\Client\Exceptions\CantSubmitClientException;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Client\Tasks\CheckClientCanBeSubmittedTask;
use App\Containers\AppSection\Client\Tasks\UpdateClientTask;
use App\Containers\AppSection\Notification\Events\Events\ClientSubmitEvent;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class SubmitClientInfoAction extends Action
{
    public function run(): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $member = $user->client->member;

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        if (!app(CheckClientCanBeSubmittedTask::class)->run($user->client)) {
            throw new CantSubmitClientException();
        }

        /** @FIXME Remove Readonly but maybe in future they want to get back readonly */
        app(UpdateClientTask::class)->run($user->client->getKey(), [
            'is_submit' => true,
            //            'readonly'  => true,
        ]);

        app(LogoutUserTask::class)->run($user);

        event(new ClientSubmitEvent($member->user_id, $member->getHashedKey(), $member->name));
        event(new SubmitClientEvent($user->client->getKey()));
    }
}
