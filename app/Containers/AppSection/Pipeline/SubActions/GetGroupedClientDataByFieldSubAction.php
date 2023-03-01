<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\SubActions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Pipeline\Tasks\GetGroupedLeadsTask;
use App\Containers\AppSection\Pipeline\Tasks\GetPreparedPipelineData;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\SubAction;

class GetGroupedClientDataByFieldSubAction extends SubAction
{
    public function run(string $type, string $field): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $preparedData = app(GetPreparedPipelineData::class)->run($type);
        /** @var GetGroupedLeadsTask $task */
        $task = app(GetGroupedLeadsTask::class);

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $task = $task->filterByUser($user->getKey());
        } elseif ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $task = $task->filterByCompany($user->company_id);
        }

        $data = $task->run($type, $field);
        foreach ($data as $period) {
            if (isset($preparedData[$period->period])) {
                $preparedData[$period->period]['count'] = $period->count;
            }
        }

        return $preparedData;
    }
}
