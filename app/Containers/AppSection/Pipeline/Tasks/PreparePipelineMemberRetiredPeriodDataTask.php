<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class PreparePipelineMemberRetiredPeriodDataTask extends Task
{
    public function run(): array
    {
        $date         = Carbon::now()->subMonths(11);
        $endDate      = Carbon::now();
        $data         = [];
        while (!$date->diff($endDate)->invert) {
            $data[$date->format('Y-m')] = [
                'month'     => $date->format('M'),
                'retired'   => 0,
                'employers' => 0,
            ];
            $date->addMonth();
        }

        return $data;
    }
}
