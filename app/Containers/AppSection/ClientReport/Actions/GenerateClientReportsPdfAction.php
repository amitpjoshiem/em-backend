<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportStatusEnum;
use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportTypeEnum;
use App\Containers\AppSection\ClientReport\Data\Transporters\GenerateClientReportsPdfTransporter;
use App\Containers\AppSection\ClientReport\Events\Events\GeneratePdfEvent;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Containers\AppSection\ClientReport\Tasks\CreateClientReportDocTask;
use App\Containers\AppSection\ClientReport\Tasks\GetAllClientReportsTask;
use App\Containers\AppSection\ClientReport\Tasks\SaveClientReportDocContractsTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GenerateClientReportsPdfAction extends Action
{
    public function run(GenerateClientReportsPdfTransporter $clientReportData): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($clientReportData->member_id);

        /** @var ClientReportsDoc $clientReportDoc */
        $clientReportDoc = app(CreateClientReportDocTask::class)->run([
            'member_id' => $clientReportData->member_id,
            'user_id'   => $user->getKey(),
            'status'    => ClientReportDocsExportStatusEnum::PROCESS,
            'filename'  => sprintf('%s_%d.pdf', str_replace(' ', '_', $member->name), now()->timestamp),
            'type'      => ClientReportDocsExportTypeEnum::PDF,
            'contracts' => $clientReportData->contracts,
        ]);
        $contracts = $clientReportData->contracts;

        if ($contracts === null) {
            /** @var Collection $allContracts */
            $allContracts = app(GetAllClientReportsTask::class)
                ->filterByMember($clientReportData->member_id)
                ->run();
            $contracts = $allContracts->pluck('id')->toArray();
        }

        app(SaveClientReportDocContractsTask::class)->run($clientReportDoc->id, $contracts);
        event(new GeneratePdfEvent($clientReportDoc->id, $contracts));
    }
}
