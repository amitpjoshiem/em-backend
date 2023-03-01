<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Events\Handlers;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\Authorization\Tasks\RemoveUserRoleTask;
use App\Containers\AppSection\Member\Events\Events\ProspectConvertToClientEvent;
use App\Containers\AppSection\Member\Mails\RestoreMemberClientMail;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Actions\CreateClientForMemberAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ProspectConvertToClientEventHandler implements ShouldQueue
{
    public function handle(ProspectConvertToClientEvent $event): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['client.user'])->run($event->memberId);

        if ($member->client !== null) {
            $member->client->user->restore();
            app(RemoveUserRoleTask::class)->run($member->client->user, RolesEnum::lead()->value);
            app(AssignUserToRolesTask::class)->run($member->client->user, [RolesEnum::client()->value]);
            Mail::send((new RestoreMemberClientMail($member->client->user->email))->onQueue('email'));

            return;
        }

        app(CreateClientForMemberAction::class)->run($member->getKey());
    }
}
