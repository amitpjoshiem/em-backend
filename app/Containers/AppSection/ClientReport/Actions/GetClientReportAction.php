<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\GetClientReportTransporter;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Containers\AppSection\ClientReport\Tasks\FindClientReportByIdTask;
use App\Ship\Parents\Actions\Action;

class GetClientReportAction extends Action
{
    public function run(GetClientReportTransporter $clientReportData): ClientReport
    {
        return app(FindClientReportByIdTask::class)->withMember()->run($clientReportData->id);
    }
}
