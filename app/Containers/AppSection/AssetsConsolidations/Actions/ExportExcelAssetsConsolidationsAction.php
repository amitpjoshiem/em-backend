<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Actions;

use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportStatusEnum;
use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportTypeEnum;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\CreateExportExcelAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\ExportExcelAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Events\Events\GenerateExcelExportEvent;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsExportTask;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class ExportExcelAssetsConsolidationsAction extends Action
{
    public function run(ExportExcelAssetsConsolidationsTransporter $input): AssetsConsolidationsExport
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        /** @var Member $member */
        $member              = app(FindMemberByIdTask::class)->run($input->member_id);
        $memberFormattedName = str_replace(' ', '_', $member->name);
        $createdAt           = now();
        $filename            = sprintf('AssetsConsolidationReport_%s_%s.xlsx', $memberFormattedName, $createdAt->timestamp);
        $data                = new CreateExportExcelAssetsConsolidationsTransporter([
            'user_id'    => $user->getKey(),
            'member_id'  => $input->member_id,
            'status'     => AssetsConsolidationsExportStatusEnum::PROCESS,
            'type'       => AssetsConsolidationsExportTypeEnum::EXCEL,
            'filename'   => $filename,
            'created_at' => $createdAt,
        ]);
        $assetsConsolidationExport = app(CreateAssetsConsolidationsExportTask::class)->run($data);
        event(new GenerateExcelExportEvent($assetsConsolidationExport));

        return $assetsConsolidationExport;
    }
}
