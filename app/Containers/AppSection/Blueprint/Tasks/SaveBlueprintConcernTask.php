<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintConcernRepository;
use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintConcernTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveBlueprintConcernTask extends Task
{
    public function __construct(protected BlueprintConcernRepository $repository)
    {
    }

    public function run(SaveBlueprintConcernTransporter $data): BlueprintConcern
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
