<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\InvestmentPackageRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateInvestmentPackageTask extends Task
{
    public function __construct(protected InvestmentPackageRepository $repository)
    {
    }

    public function run(array $data): InvestmentPackage
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
