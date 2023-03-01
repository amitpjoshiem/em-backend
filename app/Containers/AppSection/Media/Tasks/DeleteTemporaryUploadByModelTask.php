<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteTemporaryUploadByModelTask extends Task
{
    public function run(Model $model): bool
    {
        try {
            return (bool)$model->delete();
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}
