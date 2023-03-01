<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\GetCompanyAdvisorsTransporter;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetCompanyAdvisorsAction extends Action
{
    public function run(GetCompanyAdvisorsTransporter $data): Collection|LengthAwarePaginator
    {
        return app(GetAllUsersTask::class)
            ->addRequestCriteria()
            ->withRole(RolesEnum::ADVISOR)
            ->withRoles()
            ->withCompany()
            ->withMedia()
            ->filterByCompany($data->company_id)
            ->run(false);
    }
}
