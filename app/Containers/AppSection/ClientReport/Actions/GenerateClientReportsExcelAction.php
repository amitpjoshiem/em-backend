<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportStatusEnum;
use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportTypeEnum;
use App\Containers\AppSection\ClientReport\Data\Transporters\GenerateClientReportsExcelTransporter;
use App\Containers\AppSection\ClientReport\Events\Events\GenerateExcelEvent;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Containers\AppSection\ClientReport\Tasks\CreateClientReportDocTask;
use App\Containers\AppSection\ClientReport\Tasks\GetAllClientReportsTask;
use App\Containers\AppSection\ClientReport\Tasks\SaveClientReportDocContractsTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GenerateClientReportsExcelAction extends Action
{
    public function run(GenerateClientReportsExcelTransporter $clientReportData): void
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
            'filename'  => sprintf('%s_%d.xlsx', str_replace(' ', '_', $member->name), now()->timestamp),
            'type'      => ClientReportDocsExportTypeEnum::EXCEL,
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
        event(new GenerateExcelEvent($clientReportDoc->id, $contracts));
    }
}
