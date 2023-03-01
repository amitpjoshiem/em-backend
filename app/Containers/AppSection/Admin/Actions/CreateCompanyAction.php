<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\CreateCompanyTransporter;
use App\Containers\AppSection\Admin\Tasks\AdminRegisterCompanyTask;
use App\Containers\AppSection\User\Models\Company;
use App\Ship\Parents\Actions\SubAction;

class CreateCompanyAction extends SubAction
{
    public function run(CreateCompanyTransporter $data): Company
    {
        return app(AdminRegisterCompanyTask::class)->run($data->toArray());
    }
}
