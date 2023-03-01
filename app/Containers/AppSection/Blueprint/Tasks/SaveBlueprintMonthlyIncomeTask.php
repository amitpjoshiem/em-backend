<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tasks;

use App\Containers\AppSection\Blueprint\Data\Repositories\BlueprintMonthlyIncomeRepository;
use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintMonthlyIncomeTransporter;
use App\Containers\AppSection\Blueprint\Models\BlueprintMonthlyIncome;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveBlueprintMonthlyIncomeTask extends Task
{
    public function __construct(protected BlueprintMonthlyIncomeRepository $repository)
    {
    }

    public function run(SaveBlueprintMonthlyIncomeTransporter $data): BlueprintMonthlyIncome
    {
        try {
            return $this->repository->updateOrCreate(
                ['member_id' => $data->member_id],
                $data->toArray()
            );
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
