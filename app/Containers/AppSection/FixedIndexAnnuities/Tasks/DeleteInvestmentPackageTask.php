<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\InvestmentPackageRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteInvestmentPackageTask extends Task
{
    public function __construct(protected InvestmentPackageRepository $repository)
    {
    }

    public function run(int $id): bool
    {
        try {
            return (bool)$this->repository->delete($id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
