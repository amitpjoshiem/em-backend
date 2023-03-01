<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tasks\AssetAllocation;

use App\Containers\AppSection\Member\Data\Repositories\MemberAssetAllocationRepository;
use App\Containers\AppSection\Member\Data\Transporters\SaveAssetAllocationTransporter;
use App\Containers\AppSection\Member\Models\MemberAssetAllocation;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveAssetAllocationTask extends Task
{
    public function __construct(protected MemberAssetAllocationRepository $repository)
    {
    }

    public function run(SaveAssetAllocationTransporter $data): MemberAssetAllocation
    {
        try {
            return $this->repository->updateOrCreate(
                ['member_id' => $data->member_id],
                $data->toArray()
            );
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
