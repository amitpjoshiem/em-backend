<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class PreparePipelinePeriodDataTask extends Task
{
    public function run(): array
    {
        $date         = Carbon::now()->subMonths(11);
        $endDate      = Carbon::now();
        $data         = [];
        while (!$date->diff($endDate)->invert) {
            $data[$date->format('Y-m')] = [
                'period' => $date->format('M'),
                'amount' => 0,
            ];
            $date->addMonth();
        }

        return $data;
    }
}
