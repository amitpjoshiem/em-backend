<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\FixedIndexAnnuitiesRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateFixedIndexAnnuitiesTask extends Task
{
    public function __construct(protected FixedIndexAnnuitiesRepository $repository)
    {
    }

    public function run(array $data): FixedIndexAnnuities
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
