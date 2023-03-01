<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\DeleteCompanyTransporter;
use App\Containers\AppSection\User\Tasks\DeleteCompanyTask;
use App\Containers\AppSection\User\Tasks\DeleteCompanyUsersTask;
use App\Ship\Parents\Actions\SubAction;

class DeleteCompanyAction extends SubAction
{
    public function run(DeleteCompanyTransporter $data): void
    {
        app(DeleteCompanyUsersTask::class)->run($data->id);

        app(DeleteCompanyTask::class)->run($data->id);
    }
}
