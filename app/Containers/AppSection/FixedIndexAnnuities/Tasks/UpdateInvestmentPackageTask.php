<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Tasks;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Repositories\InvestmentPackageRepository;
use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateInvestmentPackageTask extends Task
{
    public function __construct(protected InvestmentPackageRepository $repository)
    {
    }

    public function run(int $id, array $data): InvestmentPackage
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
