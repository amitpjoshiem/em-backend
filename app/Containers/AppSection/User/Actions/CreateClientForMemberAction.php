<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Activity\Events\Events\LeadAddedEvent;
use App\Containers\AppSection\Admin\Actions\SendCreatePasswordSubAction;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\Client\Tasks\SaveClientTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateClientForMemberAction extends Action
{
    public function run(int $memberId): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['user.company'])->run($memberId);

        /** @var User $client */
        $client = app(CreateUserByCredentialsTask::class)->run(
            $member->email,
            Hash::make(Str::random()),
            $member->email,
            $member->user->company->getKey(),
        );

        // NOTE: if not using a single general role for all Admins, comment out that line below. And assign Roles to your users manually.
        app(AssignUserToRolesTask::class)->run($client, [RolesEnum::CLIENT]);

        app(SendCreatePasswordSubAction::class)->run($client);

        app(SaveClientTask::class)->run($client->getKey(), $member->getKey());

        event(new LeadAddedEvent($member->user->getKey(), $member->getKey()));
    }
}
