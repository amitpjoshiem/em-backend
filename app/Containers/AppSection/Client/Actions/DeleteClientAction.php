<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Activity\Events\Events\ClientAccountDeactivatedEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\DeleteClientTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Ship\Parents\Actions\Action;
use Laravel\Passport\Token;

class DeleteClientAction extends Action
{
    public function run(DeleteClientTransporter $data): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['client.user'])->run($data->member_id);

        /** @var Token $token */
        foreach ($member->client->user->tokens as $token) {
            $token->revoke();
            $token->delete();
        }

        app(DeleteUserTask::class)->run($member->client->user);

        event(new ClientAccountDeactivatedEvent($user->getKey(), $member->getKey()));
    }
}
