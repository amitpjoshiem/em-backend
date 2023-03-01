<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Repositories\MediaRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UpdateMediaTask extends Task
{
    public function __construct(protected MediaRepository $repository)
    {
    }

    public function run(int $mediaId, array $data): Media
    {
        try {
            return $this->repository->update($data, $mediaId);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException(previous: $exception);
        }
    }
}
