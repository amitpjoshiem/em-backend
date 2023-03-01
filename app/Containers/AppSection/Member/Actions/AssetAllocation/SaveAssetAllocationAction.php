<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\AssetAllocation;

use App\Containers\AppSection\Member\Data\Transporters\SaveAssetAllocationTransporter;
use App\Containers\AppSection\Member\Tasks\AssetAllocation\SaveAssetAllocationTask;
use App\Ship\Parents\Actions\Action;

class SaveAssetAllocationAction extends Action
{
    public function run(SaveAssetAllocationTransporter $data): object
    {
        return app(SaveAssetAllocationTask::class)->run($data);
    }
}
