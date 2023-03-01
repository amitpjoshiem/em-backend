<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\UpdateClientReportTransporter;
use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Containers\AppSection\ClientReport\Tasks\UpdateClientReportTask;
use App\Ship\Parents\Actions\Action;

class UpdateClientReportAction extends Action
{
    public function run(UpdateClientReportTransporter $input): ClientReport
    {
        $data = $this->prepareData($input);

        return app(UpdateClientReportTask::class)->run($input->id, $data);
    }

    private function prepareData(UpdateClientReportTransporter $input): array
    {
        $data = $input->except('id', 'current_year', 'since_inception')->toArray();

        if ($input->current_year !== null) {
            foreach ($input->current_year->toArray() as $item => $value) {
                if ($item === 'interest_credited') {
                    $data['current_interest_credited'] = $value;
                    continue;
                } elseif ($item === 'beginning_balance') {
                    $data['origination_value'] = $value;
                    continue;
                }

                $data[$item] = $value;
            }
        }

        if ($input->since_inception !== null) {
            foreach ($input->since_inception->toArray() as $item => $value) {
                if ($item === 'interest_credited') {
                    $data['since_interest_credited'] = $value;
                    continue;
                }

                $data[$item] = $value;
            }
        }

        return $data;
    }
}
