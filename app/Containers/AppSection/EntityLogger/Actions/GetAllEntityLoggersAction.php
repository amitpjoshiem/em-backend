<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\EntityLogger\Models\EntityLog;
use App\Containers\AppSection\EntityLogger\Tasks\GetAllEntityLoggersTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllEntityLoggersAction extends Action
{
    /**
     * @return Collection|EntityLog[]|LengthAwarePaginator
     */
    public function run(): Collection | array | LengthAwarePaginator
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $userIds = [];

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $userIds = $user->assistants->pluck('id')->toArray();
        }

        return app(GetAllEntityLoggersTask::class)
            ->withRelations(['user'])
            ->filterByUsers($userIds)
            ->addRequestCriteria(fieldsToDecode: ['id', 'user_id'])
            ->run();
    }
}
