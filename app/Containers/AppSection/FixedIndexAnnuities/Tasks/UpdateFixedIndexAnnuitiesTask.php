<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\FixedIndexAnnuitiesRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateFixedIndexAnnuitiesTask extends Task
{
    public function __construct(protected FixedIndexAnnuitiesRepository $repository)
    {
    }

    public function run(int $id, array $data): FixedIndexAnnuities
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
