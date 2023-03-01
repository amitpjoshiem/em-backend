<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Data\Transporters\GetAllMembersTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\GetAllMembersTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllMembersAction extends Action
{
    /**
     * @return Collection|Member[]|LengthAwarePaginator
     *
     * @throws RepositoryException
     * @throws UserNotFoundException
     */
    public function run(GetAllMembersTransporter $data): Collection | array | LengthAwarePaginator
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetAllMembersTask $membersTask */
        $membersTask = app(GetAllMembersTask::class)
            ->addRequestCriteria()
            ->filterByOwner()
            ->withTrashed($user->hasRole('admin'))
            ->withRelations([
                'spouse',
                'employmentHistory',
                'spouse.employmentHistory',
                'house',
                'other',
                'media',
                'contacts',
                'client',
                'client.user',
                'user',
                'salesforce.opportunity.childOpportunities',
            ]);

        $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
        $membersTask->filterByCompany($companyId);

        if (isset($data->status)) {
            $membersTask->filterByStatus($data->status);
        }

        return $membersTask->run();
    }
}
