<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Repositories\TemporaryUploadRepository;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateTemporaryUploadTask extends Task
{
    public function __construct(private TemporaryUploadRepository $repository)
    {
    }

    public function run(array $data): TemporaryUpload
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
