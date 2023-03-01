<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateClientReportTask extends Task
{
    public function __construct(protected ClientReportRepository $repository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(int $memberId, int $contractNumber): ClientReport
    {
        return $this->repository->create([
            'member_id'       => $memberId,
            'contract_number' => $contractNumber,
            'is_custom'       => true,
        ]);
    }
}
