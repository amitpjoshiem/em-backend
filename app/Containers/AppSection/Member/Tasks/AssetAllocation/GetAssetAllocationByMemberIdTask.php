<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks\AssetAllocation;

use App\Containers\AppSection\Member\Data\Repositories\MemberAssetAllocationRepository;
use App\Containers\AppSection\Member\Models\MemberAssetAllocation;
use App\Ship\Parents\Tasks\Task;

class GetAssetAllocationByMemberIdTask extends Task
{
    public function __construct(protected MemberAssetAllocationRepository $repository)
    {
    }

    public function run(int $member_id): ?MemberAssetAllocation
    {
        return $this->repository->findByField('member_id', $member_id)->first();
    }
}
