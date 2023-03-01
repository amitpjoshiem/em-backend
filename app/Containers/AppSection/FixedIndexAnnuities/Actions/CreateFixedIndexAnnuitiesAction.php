<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\CreateFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\CreateFixedIndexAnnuitiesTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Ship\Parents\Actions\Action;

class CreateFixedIndexAnnuitiesAction extends Action
{
    public function run(CreateFixedIndexAnnuitiesTransporter $fixedindexannuitiesData): FixedIndexAnnuities
    {
        $input = $fixedindexannuitiesData->sanitizeInput([
            'name',
            'insurance_provider',
            'date_signed',
            'tax_qualification',
            'agent_rep_code',
            'license_number',
            'member_id',
        ]);

        $fixedIndexAnnuities = app(CreateFixedIndexAnnuitiesTask::class)->run($input);

        app(AttachMediaFromUuidsToModelSubAction::class)->run($fixedIndexAnnuities, $fixedindexannuitiesData->uuids, MediaCollectionEnum::FIXED_INDEX_ANNUITIES);

        return $fixedIndexAnnuities;
    }
}
