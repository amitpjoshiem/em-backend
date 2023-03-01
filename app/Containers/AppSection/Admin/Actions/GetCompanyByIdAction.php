<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\GetCompanyByIdTransporter;
use App\Containers\AppSection\User\Models\Company;
use App\Containers\AppSection\User\Tasks\FindCompanyByIdTask;
use App\Ship\Parents\Actions\SubAction;

class GetCompanyByIdAction extends SubAction
{
    public function run(GetCompanyByIdTransporter $data): Company
    {
        return app(FindCompanyByIdTask::class)->run($data->id);
    }
}
