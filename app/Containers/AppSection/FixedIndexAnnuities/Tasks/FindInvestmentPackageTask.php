<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\InvestmentPackageRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;
use Exception;

class FindInvestmentPackageTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected InvestmentPackageRepository $repository)
    {
    }

    public function run(int $id): InvestmentPackage
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
