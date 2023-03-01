<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\UpdateCompanyTransporter;
use App\Containers\AppSection\Admin\Tasks\AdminEditCompanyTask;
use App\Containers\AppSection\User\Models\Company;
use App\Ship\Parents\Actions\SubAction;

class UpdateCompanyAction extends SubAction
{
    public function run(UpdateCompanyTransporter $data): Company
    {
        return app(AdminEditCompanyTask::class)->run($data->except('id')->toArray(), $data->id);
    }
}
