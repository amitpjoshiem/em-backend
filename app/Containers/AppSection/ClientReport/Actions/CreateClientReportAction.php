<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\CreateClientReportTransporter;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Containers\AppSection\ClientReport\Tasks\CreateClientReportTask;
use App\Ship\Parents\Actions\Action;

class CreateClientReportAction extends Action
{
    public function run(CreateClientReportTransporter $input): ClientReport
    {
        return app(CreateClientReportTask::class)->run($input->member_id, $input->contract_number);
    }
}
