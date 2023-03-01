<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Repositories\MediaRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteAllModelMediaTask extends Task
{
    public function __construct(protected MediaRepository $repository)
    {
    }

    public function run(Model $model): bool
    {
        try {
            return (bool)$this->repository->deleteWhere([
                'model_type' => $model::class,
                'model_id'   => $model->getKey(),
            ]);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}
