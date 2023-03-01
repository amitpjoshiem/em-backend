<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\SignFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Containers\AppSection\FixedIndexAnnuities\SubActions\GetEnvelopUrlSubAction;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindFixedIndexAnnuitiesByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class SignFixedIndexAnnuitiesAction extends Action
{
    public function run(SignFixedIndexAnnuitiesTransporter $fixedindexannuitiesData): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var FixedIndexAnnuities $fixedIndexAnnuity */
        $fixedIndexAnnuity = app(FindFixedIndexAnnuitiesByIdTask::class)->withRelations(['member'])->run($fixedindexannuitiesData->id);

        return ['url' => app(GetEnvelopUrlSubAction::class)->run(
            $fixedIndexAnnuity,
            $user->getKey(),
            $fixedIndexAnnuity->member->getKey()
        )];
    }
}
