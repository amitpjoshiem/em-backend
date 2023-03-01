<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintDocRepository;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateBlueprintDocTask extends Task
{
    public function __construct(protected BlueprintDocRepository $repository)
    {
    }

    public function run(array $data): BlueprintDoc
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
