<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Tasks;

use App\Containers\AppSection\ClientReport\Data\Repositories\ClientReportRepository;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Carbon;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateClientReportByCsvDataTask extends Task
{
    public function __construct(protected ClientReportRepository $repository)
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(array $csvData, int $memberId): ClientReport
    {
        return $this->repository->create([
            'member_id'         => $memberId,
            'contract_number'   => $csvData['ContractNumber'],
            'carrier'           => $csvData['CarrierName'],
            'current_value'     => $csvData['CurrentValue'],
            'surrender_value'   => $csvData['SurrenderValue'],
            'origination_value' => $csvData['OriginationValue'],
            'origination_date'  => Carbon::create($csvData['OriginationDate']),
        ]);
    }
}
