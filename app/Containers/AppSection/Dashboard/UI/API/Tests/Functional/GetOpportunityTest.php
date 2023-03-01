<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Tests\Functional;

use App\Containers\AppSection\Dashboard\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class GetOpportunityTest.
 *
 * @group init
 * @group api
 */
class GetOpportunityTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/dashboard/opportunity';

    /**
     * @var string[]
     */
    private const TYPES = [
        'year',
        'month',
        'quarter',
    ];

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testGetEmptyOpportunity(): void
    {
        $this->getTestingUser();

        foreach (self::TYPES as $type) {
            $response = $this->makeCall([
                'type'  => $type,
            ]);

            $response->assertSuccessful();

            $content = $response->getOriginalContent();

            $this->assertArrayHasKey('data', $content);

            $data = $content['data'];
            $this->assertNull($data['total']);
            $this->assertEquals(0, $data['percent']);
            $this->assertNull($data['up']);

            switch ($type) {
                case 'month':
                    $startDay = Carbon::now()->subDays(29);
                    foreach ($data['values'] as $value) {
                        $this->assertEquals(0, $value['amount']);
                        $this->assertEquals($startDay->format('d'), $value['period']);
                        $startDay = $startDay->addDay();
                    }

                    break;
                case 'quarter':
                    $startWeek = Carbon::now()->subWeeks(11);
                    foreach ($data['values'] as $value) {
                        $this->assertEquals(0, $value['amount']);
                        $this->assertEquals($startWeek->format('W'), $value['period']);
                        $startWeek = $startWeek->addWeek();
                    }

                    break;
                case 'year':
                    $startMonth = Carbon::now()->subMonths(11);
                    foreach ($data['values'] as $value) {
                        $this->assertEquals(0, $value['amount']);
                        $this->assertEquals($startMonth->format('M'), $value['period']);
                        $startMonth = $startMonth->addMonth();
                    }

                    break;
            }
        }
    }

    /**
     * @test
     */
    public function testGetOpportunity(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $childOpps = collect();
        Member::factory()->count(200)->create([
            'user_id'   => $user->getKey(),
        ])->each(function (Member $member) use (&$childOpps): void {
            $childOpps = $childOpps->merge(SalesforceChildOpportunity::factory()->count(5)->create([
                'member_id' => $member->getKey(),
                'user_id'   => $member->user_id,
            ]));
        });
        foreach (self::TYPES as $type) {
            $response = $this->makeCall([
                'type'  => $type,
            ]);

            $response->assertSuccessful();

            $content = $response->getOriginalContent();

            $this->assertArrayHasKey('data', $content);

            $data = $content['data'];

            switch ($type) {
                case 'month':
                    $this->assertMonth($data, $childOpps);
                    break;
                case 'quarter':
                    $this->assertQuarter($data, $childOpps);
                    break;
                case 'year':
                    $this->assertYear($data, $childOpps);
                    break;
            }
        }
    }

    private function assertMonth(array $data, Collection $childOpps): void
    {
        $startDay            = Carbon::now()->subDays(29)->startOfDay();
        $previousPeriodStart = Carbon::now()->subDays(60)->startOfDay();
        $groupedChildOpps    = $this->preparePeriodAssertion($childOpps, $data, $startDay, $previousPeriodStart, 'Y-m-d');
        /**
         * @var string     $date
         * @var Collection $groupedChildOpp
         */
        foreach ($groupedChildOpps as $date => $groupedChildOpp) {
            $day = Carbon::createFromFormat('Y-m-d', $date);
            $this->assertNotFalse($day);
            $has = false;
            foreach ($data['values'] as $value) {
                if ($value['period'] === $day->format('d')) {
                    $this->assertEquals($groupedChildOpp->sum('amount'), $value['amount']);
                    $has = true;
                }
            }

            $this->assertTrue($has);
        }
    }

    private function assertQuarter(array $data, Collection $childOpps): void
    {
        /** @var Carbon $startWeek */
        $startWeek           = Carbon::now()->subWeeks(11)->startOfWeek();
        $previousPeriodStart = Carbon::now()->subWeeks(23)->startOfWeek();
        $groupedChildOpps    = $this->preparePeriodAssertion($childOpps, $data, $startWeek, $previousPeriodStart, 'W');
        /**
         * @var int        $date
         * @var Collection $groupedChildOpp
         */
        foreach ($groupedChildOpps as $date => $groupedChildOpp) {
            $week          = Carbon::now()->setISODate($startWeek->year, $date);
            $has           = false;
            foreach ($data['values'] as $value) {
                if ($value['period'] === $week->format('W')) {
                    $this->assertEquals($groupedChildOpp->sum('amount'), $value['amount']);
                    $has = true;
                }
            }

            $this->assertTrue($has);
            $startWeek->addWeek();
        }
    }

    private function assertYear(array $data, Collection $childOpps): void
    {
        $startMonth          = Carbon::now()->subMonths(11)->startOfMonth();
        $previousPeriodStart = Carbon::now()->subMonths(23)->startOfMonth();
        $groupedChildOpps    = $this->preparePeriodAssertion($childOpps, $data, $startMonth, $previousPeriodStart, 'Y-m');
        /**
         * @var string     $date
         * @var Collection $groupedChildOpp
         */
        foreach ($groupedChildOpps as $date => $groupedChildOpp) {
            $month = Carbon::createFromFormat('Y-m', $date);
            $this->assertNotFalse($month);
            $has = false;
            foreach ($data['values'] as $value) {
                if ($value['period'] === $month->format('M')) {
                    $this->assertEquals($groupedChildOpp->sum('amount'), $value['amount']);
                    $has = true;
                }
            }

            $this->assertTrue($has);
        }
    }

    private function preparePeriodAssertion(Collection $childOpps, array $data, Carbon $start, Carbon $previousStart, string $groupByFormat): Collection
    {
        $start               = $start->toImmutable();
        $sortedChildOpps     = $childOpps->filter(static function (SalesforceChildOpportunity $childOpportunity) use ($start): bool {
            return $childOpportunity->created_at->betweenIncluded($start, now());
        });
        $sortedPreviousChildOpps = $childOpps->filter(static function (SalesforceChildOpportunity $childOpportunity) use ($previousStart, $start): bool {
            return $childOpportunity->created_at->betweenIncluded($previousStart, $start->subDay()->endOfDay());
        });
        $sum         = $sortedChildOpps->sum('amount');
        $previousSum = $sortedPreviousChildOpps->sum('amount');
        $this->assertEquals($sum, $data['total']);
        $percent = $previousSum === 0 ? 1 : ($sum - $previousSum) / $previousSum;
        $this->assertEquals(abs($percent) * 100, $data['percent']);
        $this->assertEquals($percent > 0, $data['up']);

        return $sortedChildOpps->groupBy(
            fn (SalesforceChildOpportunity $childOpportunity): string => $childOpportunity->created_at->format($groupByFormat)
        );
    }
}
