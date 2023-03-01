<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Tasks;

use App\Containers\AppSection\Dashboard\Actions\DashboardOpportunityAction;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use stdClass;

class GetSortedOpportunityData extends Task
{
    public function run(Collection $childOpportunities, string $type, array $preparedData): stdClass
    {
        $total                = 0;
        $format               = DashboardOpportunityAction::SORT_TYPES[$type]['format'];
        $previousPeriod       = $this->getPreviousPeriod($type);
        $previousPeriodAmount = 0;
        /** @var SalesforceChildOpportunity $childOpportunity */
        foreach ($childOpportunities as $childOpportunity) {
            if ($childOpportunity->created_at->betweenIncluded($previousPeriod['start'], $previousPeriod['end'])) {
                $previousPeriodAmount += $childOpportunity->amount;
                continue;
            }

            $group = $childOpportunity->created_at->format($format);

            if (isset($preparedData['values'][$group]) && $childOpportunity->created_at->diff($previousPeriod['end'])->invert === 1) {
                $preparedData['values'][$group]['amount'] += $childOpportunity->amount;
                $total                                    += $childOpportunity->amount;
            }
        }

        $preparedData['total']   = $total === 0 ? null : $total;
        $preparedData['percent'] = $previousPeriodAmount !== 0 ? ($total - $previousPeriodAmount) / $previousPeriodAmount : 1;

        return (object)$preparedData;
    }

    private function getPreviousPeriod(string $type): array
    {
        return match ($type) {
            'year'  => [
                'start' => Carbon::now()->subMonths(23)->startOfMonth(),
                'end'   => Carbon::now()->subMonths(12)->endOfMonth(),
            ],
            'quarter' => [
                'start' => Carbon::now()->subWeeks(23)->startOfWeek(),
                'end'   => Carbon::now()->subWeeks(12)->endOfWeek(),
            ],
            'month' => [
                'start' => Carbon::now()->subDays(60)->startOfDay(),
                'end'   => Carbon::now()->subDays(30)->endOfDay(),
            ],
            default => []
        };
    }
}
