<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\SubAction;

class isMemberOwnerSubAction extends SubAction
{
    /**
     * @throws NotFoundException
     */
    public function run(int $memberId): bool
    {
        /** @var User | null $user */
        $user = app(GetAuthenticatedUserTask::class)->run();

        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($memberId);

        if ($user === null) {
            return false;
        }

        if ($user->client?->member->getKey() === $member->getKey()) {
            return true;
        }

        return $user->id === $member->user_id;
    }
}
