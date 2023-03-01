<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Tests\Functional;

use App\Containers\AppSection\Dashboard\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Yodlee\Models\YodleeAccounts;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class GetAllInitTest.
 *
 * @group init
 * @group api
 */
class GetPipelineTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/dashboard/pipeline';

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
    public function testGetEmptyPipeline(): void
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
            $this->assertEmpty(array_diff([
                'members'     => 0,
                'new_members' => 0,
                'aum'         => null,
                'new_aum'     => null,
            ], $data));
        }
    }

    /**
     * @test
     */
    public function testGetPipeline(): void
    {
        $user = $this->getTestingUser();

        $countForPeriod = 5;
        Member::factory()->count($countForPeriod)->create([
            'created_at'    => Carbon::now(),
            'user_id'       => $user->getKey(),
        ]);
        Member::factory()->count($countForPeriod)->create([
            'created_at'    => Carbon::now()->subMonths(2),
            'user_id'       => $user->getKey(),
        ]);
        Member::factory()->count($countForPeriod)->create([
            'created_at'    => Carbon::now()->subQuarters(2),
            'user_id'       => $user->getKey(),
        ]);
        Member::factory()->count($countForPeriod)->create([
            'created_at'    => Carbon::now()->subYears(2),
            'user_id'       => $user->getKey(),
        ]);
        $aum = collect();
        Member::where([
            'user_id' => $user->getKey(),
            'type'    => Member::CLIENT,
        ])->get()->each(function (Member $member) use (&$aum): void {
            $currentAccounts = YodleeAccounts::factory()->count(5)->create([
                'member_id' => $member->getKey(),
            ]);
            $aum = $aum->merge($currentAccounts);
        });
        foreach (self::TYPES as $type) {
            $response = $this->makeCall([
                'type'  => $type,
            ]);

            $response->assertSuccessful();

            $content = $response->getOriginalContent();

            $this->assertArrayHasKey('data', $content);

            $aumTotal = round($aum->sum('balance'), 3);
            $data     = $content['data'];

            switch ($type) {
                case 'month':
                    $this->assertPeriod($aum, $aumTotal, $data, $countForPeriod, 1, now()->subMonth()->startOfDay());
                    break;
                case 'quarter':
                    $this->assertPeriod($aum, $aumTotal, $data, $countForPeriod, 2, now()->subQuarter()->startOfDay());
                    break;
                case 'year':
                    $this->assertPeriod($aum, $aumTotal, $data, $countForPeriod, 3, now()->subYear()->startOfDay());
                    break;
            }
        }
    }

    private function assertPeriod(
        Collection $aum,
        float $aumTotal,
        array $data,
        int $countForPeriod,
        int $coef,
        Carbon $startPeriod
    ): void {
        $this->assertEquals($aumTotal, $data['aum']);
        $newAum = $aum->filter(fn (YodleeAccounts $account): bool => $account->created_at->betweenIncluded($startPeriod, now()->addDay()->startOfDay()))->sum('balance');
        $this->assertEquals(round($newAum, 3), $data['new_aum']);
        $this->assertEquals($coef * $countForPeriod, $data['new_members']);
        $this->assertEquals(4 * $countForPeriod, $data['members']);
    }
}
