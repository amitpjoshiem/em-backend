<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\CreateInvestmentPackageTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\CreateInvestmentPackageTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Ship\Parents\Actions\Action;

class CreateInvestmentPackageAction extends Action
{
    public function run(CreateInvestmentPackageTransporter $data): InvestmentPackage
    {
        $input = $data->sanitizeInput([
            'name',
            'fixed_index_annuities_id',
        ]);

        $investmentPackage = app(CreateInvestmentPackageTask::class)->run($input);

        app(AttachMediaFromUuidsToModelSubAction::class)->run($investmentPackage, $data->uuids, MediaCollectionEnum::INVESTMENT_PACKAGE);

        return $investmentPackage;
    }
}
