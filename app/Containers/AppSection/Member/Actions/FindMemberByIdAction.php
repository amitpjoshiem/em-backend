<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\Member\Data\Transporters\FindMemberByIdTransporter;
use App\Containers\AppSection\Member\Exceptions\NotFoundMember;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class FindMemberByIdAction extends Action
{
    /**
     * @throws NotFoundException
     * @throws RepositoryException
     * @throws UserNotFoundException
     */
    public function run(FindMemberByIdTransporter $memberData): ?Member
    {
        /** @var User | null $user */
        $user = app(GetAuthenticatedUserTask::class)->run();

        if ($user === null) {
            throw new UserNotFoundException();
        }

        /** @var FindMemberByIdTask $task */
        $task = app(FindMemberByIdTask::class);

        if ($user->hasClientRole() && $memberData->id !== $user->client?->member->id) {
            throw new NotFoundMember();
        }

        return $task
            ->withTrashed($user->hasRole('admin'))
            ->withRelations(['spouse', 'contacts'])
            ->run($memberData->id);
    }
}
