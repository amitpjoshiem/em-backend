<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\AssetAllocation;

use App\Containers\AppSection\Member\Data\Transporters\GetAssetAllocationTransporter;
use App\Containers\AppSection\Member\Data\Transporters\SaveAssetAllocationTransporter;
use App\Containers\AppSection\Member\Models\MemberAssetAllocation;
use App\Containers\AppSection\Member\Tasks\AssetAllocation\GetAssetAllocationByMemberIdTask;
use App\Containers\AppSection\Member\Tasks\AssetAllocation\SaveAssetAllocationTask;
use App\Ship\Parents\Actions\Action;

class GetAssetAllocationAction extends Action
{
    public function run(GetAssetAllocationTransporter $data): MemberAssetAllocation
    {
        $assetAllocation = app(GetAssetAllocationByMemberIdTask::class)->run($data->member_id);

        if ($assetAllocation === null) {
            $data            = new SaveAssetAllocationTransporter(['member_id' => $data->member_id]);
            $assetAllocation = app(SaveAssetAllocationTask::class)->run($data);
        }

        return $assetAllocation;
    }
}
