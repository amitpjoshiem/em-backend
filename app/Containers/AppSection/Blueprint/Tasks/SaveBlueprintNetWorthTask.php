<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintNetworthRepository;
use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintNetWorthTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintNetWorth;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveBlueprintNetWorthTask extends Task
{
    public function __construct(protected BlueprintNetworthRepository $repository)
    {
    }

    public function run(SaveBlueprintNetWorthTransporter $data): BlueprintNetWorth
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
