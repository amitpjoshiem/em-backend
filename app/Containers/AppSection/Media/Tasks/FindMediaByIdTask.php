<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Repositories\MediaRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FindMediaByIdTask extends Task
{
    public function __construct(private MediaRepository $repository)
    {
    }

    public function run(int $id): Media
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new NotFoundException(previous: $exception);
        }
    }
}
