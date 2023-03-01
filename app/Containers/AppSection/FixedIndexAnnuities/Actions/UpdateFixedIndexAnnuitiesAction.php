<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\UpdateFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\UpdateFixedIndexAnnuitiesTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Ship\Parents\Actions\Action;

class UpdateFixedIndexAnnuitiesAction extends Action
{
    public function run(UpdateFixedIndexAnnuitiesTransporter $fixedindexannuitiesData): FixedIndexAnnuities
    {
        $input = $fixedindexannuitiesData->sanitizeInput([
            'name',
            'insurance_provider',
            'tax_qualification',
            'agent_rep_code',
            'license_number',
        ]);

        /** @var FixedIndexAnnuities $fixedIndexAnnuities */
        $fixedIndexAnnuities = app(UpdateFixedIndexAnnuitiesTask::class)->run($fixedindexannuitiesData->id, $input);

        if (isset($fixedindexannuitiesData->uuids)) {
            $fixedIndexAnnuities->media()->delete();
            app(AttachMediaFromUuidsToModelSubAction::class)->run($fixedIndexAnnuities, $fixedindexannuitiesData->uuids, MediaCollectionEnum::FIXED_INDEX_ANNUITIES);
            $fixedIndexAnnuities = app(UpdateFixedIndexAnnuitiesTask::class)->run($fixedIndexAnnuities->getKey(), [
                'advisor_signed' => null,
                'client_signed'  => null,
            ]);
        }

        return $fixedIndexAnnuities;
    }
}
