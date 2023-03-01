<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Tasks;

use App\Containers\AppSection\Dashboard\Actions\DashboardOpportunityAction;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetPreparedOpportunityData extends Task
{
    public function run(string $type): array
    {
        return match ($type) {
            'year' => $this->getPeriodData(
                Carbon::now()->subMonths(11),
                Carbon::now(),
                $type
            ),
            'quarter' => $this->getPeriodData(
                Carbon::now()->subWeeks(11),
                Carbon::now(),
                $type
            ),
            'month' => $this->getPeriodData(
                Carbon::now()->subDays(29),
                Carbon::now(),
                $type
            ),
            default => [],
        };
    }

    private function getPeriodData(Carbon $date, Carbon $endDate, string $type): array
    {
        $iterator     = DashboardOpportunityAction::SORT_TYPES[$type]['iterator'];
        $format       = DashboardOpportunityAction::SORT_TYPES[$type]['format'];
        $outputFormat = DashboardOpportunityAction::SORT_TYPES[$type]['outputFormat'];
        $data         = [];
        while (!$date->diff($endDate)->invert) {
            $data[$date->format($format)] = [
                'period' => $date->format($outputFormat),
                'amount' => 0,
            ];
            $date->add($iterator, 1);
        }

        return $data;
    }
}
