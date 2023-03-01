<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Pipeline\Data\Transporters\PipelinePeriodTypeTransporter;
use App\Containers\AppSection\Pipeline\Tasks\GetGroupedClosedWinLostTask;
use App\Containers\AppSection\Pipeline\Tasks\GetPreparedPipelineClosedWinLostData;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GetPipelineClosedWinLostAction extends Action
{
    public function run(PipelinePeriodTypeTransporter $data): array
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $preparedData = app(GetPreparedPipelineClosedWinLostData::class)->run($data->type);
        $data         = app(GetGroupedClosedWinLostTask::class)->run($user->getKey(), $data->type);
        foreach ($data as $period) {
            if (isset($preparedData[$period->period])) {
                $preparedData[$period->period]['win']  = $period->win;
                $preparedData[$period->period]['lost'] = $period->lost;
            }
        }

        return $preparedData;
    }
}
