<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\GetAllClientReportsDocsTransporter;
use App\Containers\AppSection\ClientReport\Tasks\GetAllClientReportsDocsByMemberIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetAllClientReportsDocsAction extends Action
{
    public function run(GetAllClientReportsDocsTransporter $clientReportData): Collection
    {
        return app(GetAllClientReportsDocsByMemberIdTask::class)
            ->addRequestCriteria()
            ->withMedia()
            ->withMember()
            ->withContracts()
            ->run($clientReportData->member_id);
    }
}
