<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Tasks;

use App\Ship\Parents\Tasks\Task;
use Carbon\Carbon;

class GetPreparedPipelineData extends Task
{
    /**
     * @var array<string, array<string, string>>
     */
    public const SORT_TYPES = [
        'year'      => [
            'format'          => 'Y-m',
            'db_format'       => '%Y-%m',
            'iterator'        => 'month',
            'outputFormat'    => 'M',
        ],
        'quarter'   => [
            'format'          => 'Y-W',
            'db_format'       => '%x-%v',
            'iterator'        => 'week',
            'outputFormat'    => 'W',
        ],
        'month'     => [
            'format'          => 'Y-m-d',
            'db_format'       => '%Y-%m-%d',
            'iterator'        => 'day',
            'outputFormat'    => 'd',
        ],
    ];

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
        $iterator     = self::SORT_TYPES[$type]['iterator'];
        $format       = self::SORT_TYPES[$type]['format'];
        $outputFormat = self::SORT_TYPES[$type]['outputFormat'];
        $data         = [];
        while (!$date->diff($endDate)->invert) {
            $data[$date->format($format)] = [
                'period' => $date->format($outputFormat),
                'count'  => 0,
            ];
            $date->add($iterator, 1);
        }

        return $data;
    }
}
