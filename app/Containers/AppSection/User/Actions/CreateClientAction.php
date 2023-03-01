<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Activity\Events\Events\LeadAddedEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Jobs\CreateClientForMemberJob;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\CreateMemberTask;
use App\Containers\AppSection\User\Data\Transporters\CreateClientTransporter;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Parents\Actions\Action;

class CreateClientAction extends Action
{
    public function run(CreateClientTransporter $userData): void
    {
        /** @var UserModel $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var Member $member */
        $member = app(CreateMemberTask::class)->run([
            'user_id'   => $user->getKey(),
            'name'      => $userData->name,
            'email'     => $userData->email,
            'step'      => MemberStepsEnum::DEFAULT,
            'type'      => Member::LEAD,
            'phone'     => $userData->phone,
        ]);

        dispatch(new CreateClientForMemberJob($member->getKey()));

        event(new CreateMemberEvent($member));

        event(new LeadAddedEvent($user->getKey(), $member->getKey()));
    }
}
