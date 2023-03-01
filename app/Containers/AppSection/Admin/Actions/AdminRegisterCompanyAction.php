<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\CompanyRegisterTransporter;
use App\Containers\AppSection\Admin\Tasks\AdminRegisterCompanyTask;
use App\Ship\Parents\Actions\Action;

class AdminRegisterCompanyAction extends Action
{
    public function run(CompanyRegisterTransporter $data): void
    {
        app(AdminRegisterCompanyTask::class)->run($data->toArray());
    }
}
