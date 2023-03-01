<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Data\Transporters\DeleteEmploymentHistoryTransporter;
use App\Containers\AppSection\Member\Tasks\DeleteEmploymentHistoryByIdTask;
use App\Ship\Parents\Actions\Action;

class DeleteEmploymentHistoryAction extends Action
{
    public function run(DeleteEmploymentHistoryTransporter $data): void
    {
        app(DeleteEmploymentHistoryByIdTask::class)->run($data->id);
    }
}
