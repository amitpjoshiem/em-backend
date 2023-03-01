<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Actions;

use App\Containers\AppSection\Pipeline\Data\Transporters\PipelinePeriodTypeTransporter;
use App\Containers\AppSection\Pipeline\SubActions\GetGroupedClientDataByFieldSubAction;
use App\Ship\Parents\Actions\Action;

class GetPipelineConvertedLeadsAction extends Action
{
    public function run(PipelinePeriodTypeTransporter $data): array
    {
        return app(GetGroupedClientDataByFieldSubAction::class)->run($data->type, 'converted_from_lead');
    }
}
