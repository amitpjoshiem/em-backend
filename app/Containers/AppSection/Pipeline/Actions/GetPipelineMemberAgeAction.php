<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Pipeline\Tasks\GetGroupedPipelineMemberAgeTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;

class GetPipelineMemberAgeAction extends Action
{
    public function run(): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @var GetGroupedPipelineMemberAgeTask $memberAgesTask */
        $memberAgesTask = app(GetGroupedPipelineMemberAgeTask::class);

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $memberAgesTask->filterByUser($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $memberAgesTask->filterByCompany($companyId);
        }

        $memberAges     = $memberAgesTask->run();

        if ($memberAges->isEmpty()) {
            return [];
        }

        $total          = 0;
        $agesGroups     = config('appSection-pipeline.age_groups');
        foreach ($memberAges as $memberAge) {
            $total += (int)$memberAge->sum;
            $agesGroups = $this->sortToGroup($memberAge, $agesGroups);
        }

        return array_map(function (array $item) use ($total): array {
            $item['count'] /= $total;

            return $item;
        }, $agesGroups);
    }

    private function sortToGroup(object $memberAge, array $agesGroups): array
    {
        foreach ($agesGroups as &$ageGroup) {
            if (!isset($ageGroup['count'])) {
                $ageGroup['count'] = 0;
            }

            if ((int)$memberAge->age >= $ageGroup['startAge'] && (int)$memberAge->age <= $ageGroup['endAge']) {
                $ageGroup['count'] += (int)$memberAge->sum;
            }
        }

        return $agesGroups;
    }
}
