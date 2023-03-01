<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;
use App\Ship\Parents\Actions\Action;

 use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
// use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
// use App\Containers\AppSection\User\Models\User;
// use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
// use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
// use Illuminate\Contracts\Pagination\LengthAwarePaginator;
// use Illuminate\Database\Eloquent\Collection;

class GetAllCrudAction extends Action
{
    public function __construct()
    {
    }

    public function run()
    {
        echo 'action comes';
        // /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        // /** @var GetAllUsersTask $task */
        // $task = app(GetAllUsersTask::class);
        echo '<pre>';
        print_r($user);
        exit;
        // if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN]) && !$adminPanel) {
        //     $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
        //     $task->filterByCompany($companyId);
        // }

        // if ($user->hasRole(RolesEnum::ASSISTANT)) {
        //     $task->filterByIds($user->advisors->pluck('id')->toArray());
        // }

        // if (!$allRoles) {
        //     $task->withRole(RolesEnum::ADVISOR);
        // }

        // return $task
        //     ->addRequestCriteria(fieldsToDecode: ['company.id'])
        //     ->withRoles()
        //     ->withCompany()
        //     ->withMedia()
        //     ->withRelations(['assistants', 'advisors'])
        //     ->ordered()
        //     ->run(false);
    }
}
