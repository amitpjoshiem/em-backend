<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\DeleteClientReportTransporter;
use App\Containers\AppSection\ClientReport\Tasks\DeleteClientReportTask;
use App\Ship\Parents\Actions\Action;

class DeleteClientReportAction extends Action
{
    public function run(DeleteClientReportTransporter $input): void
    {
        app(DeleteClientReportTask::class)->run($input->id);
    }
}
