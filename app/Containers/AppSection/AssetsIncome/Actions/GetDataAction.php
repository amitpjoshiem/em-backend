<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Actions;

use App\Containers\AppSection\AssetsIncome\Data\Transporters\GetDataTransporter;
use App\Containers\AppSection\AssetsIncome\SubActions\GetValuesSubAction;
use App\Ship\Parents\Actions\Action;
use stdClass;

class GetDataAction extends Action
{
    public function run(GetDataTransporter $data): stdClass
    {
        return app(GetValuesSubAction::class)->run($data->member_id);
    }
}
