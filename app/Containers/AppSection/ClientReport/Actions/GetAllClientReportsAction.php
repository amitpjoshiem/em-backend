<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\GetAllClientReportsTransporter;
use App\Containers\AppSection\ClientReport\Tasks\GetAllClientReportsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetAllClientReportsAction extends Action
{
    public function run(GetAllClientReportsTransporter $clientreportData): Collection
    {
        return app(GetAllClientReportsTask::class)
            ->addRequestCriteria()
            ->withMember()
            ->filterByMember($clientreportData->member_id)
            ->run();
    }
}
