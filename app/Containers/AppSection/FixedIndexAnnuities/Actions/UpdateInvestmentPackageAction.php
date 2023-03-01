<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\UpdateInvestmentPackageTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\UpdateInvestmentPackageTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Ship\Parents\Actions\Action;

class UpdateInvestmentPackageAction extends Action
{
    public function run(UpdateInvestmentPackageTransporter $data): InvestmentPackage
    {
        $input = $data->sanitizeInput([
            'name',
        ]);

        /** @var InvestmentPackage $investmentPackage */
        $investmentPackage = app(UpdateInvestmentPackageTask::class)->run($data->id, $input);

        if (isset($data->uuids)) {
            $investmentPackage->media()->delete();
            app(AttachMediaFromUuidsToModelSubAction::class)->run($investmentPackage, $data->uuids, MediaCollectionEnum::INVESTMENT_PACKAGE);
            $investmentPackage = app(UpdateInvestmentPackageTask::class)->run($investmentPackage->getKey(), [
                'advisor_signed' => null,
                'client_signed'  => null,
            ]);
        }

        return $investmentPackage;
    }
}
