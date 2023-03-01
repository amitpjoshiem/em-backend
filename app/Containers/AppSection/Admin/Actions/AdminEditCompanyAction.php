<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\CompanyEditTransporter;
use App\Containers\AppSection\Admin\Tasks\AdminEditCompanyTask;
use App\Ship\Parents\Actions\Action;

class AdminEditCompanyAction extends Action
{
    public function run(CompanyEditTransporter $data): void
    {
        app(AdminEditCompanyTask::class)->run($data->toArray(), $data->id);
    }
}
