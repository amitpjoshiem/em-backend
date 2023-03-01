<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\SignInvestmentPackageTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\FixedIndexAnnuities\SubActions\GetEnvelopUrlSubAction;
use App\Containers\AppSection\FixedIndexAnnuities\Tasks\FindInvestmentPackageTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class SignInvestmentPackageAction extends Action
{
    public function run(SignInvestmentPackageTransporter $data): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var InvestmentPackage $investmentPackage */
        $investmentPackage = app(FindInvestmentPackageTask::class)->withRelations(['fixedIndexAnnuities.member'])->run($data->id);

        return ['url' => app(GetEnvelopUrlSubAction::class)->run(
            $investmentPackage,
            $user->getKey(),
            $investmentPackage->fixedIndexAnnuities->member->getKey()
        )];
    }
}
