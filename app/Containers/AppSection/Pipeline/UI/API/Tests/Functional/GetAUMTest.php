<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Yodlee\Models\YodleeAccounts;
use Illuminate\Database\Eloquent\Collection;

class GetAUMTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/pipeline/aum';

    /**
     * @test
     */
    public function testGetEmptyAUM(): void
    {
        $this->getTestingUser();

        $response = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data       = $content['data'];
        $startMonth = now()->subMonths(11);
        foreach ($data as $month) {
            $this->assertEquals(0, $month['amount']);
            $this->assertEquals($startMonth->format('M'), $month['period']);
            $startMonth->addMonth();
        }
    }

    /**
     * @test
     */
    public function testGetAUM(): void
    {
        $user = $this->getTestingUser();

        Member::factory()->count(10)->create([
            'user_id'   => $user->getKey(),
        ])->each(function (Member $member) use ($user): void {
            YodleeAccounts::factory()->count(5)->create([
                'member_id' => $member->getKey(),
                'user_id'   => $user->getKey(),
            ]);
        });
        $clientIds = Member::where([
            'type'      => Member::CLIENT,
            'user_id'   => $user->getKey(),
        ])->get(['id']);
        $accounts = YodleeAccounts::whereIn('member_id', $clientIds->pluck('id')->toArray())->whereDate('created_at', '>=', now()->subMonths(11)->startOfMonth())->get();
        $accounts = $accounts->groupBy(function (YodleeAccounts $account): string {
            return $account->created_at->format('Y-m');
        });
        $response = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data       = $content['data'];
        $startMonth = now()->subMonths(11);
        foreach ($data as $month) {
            /** @var Collection | null $currentAccounts */
            $currentAccounts = $accounts->get($startMonth->format('Y-m'));

            if ($currentAccounts === null) {
                $this->assertEquals(0, $month['amount']);
            } else {
                $this->assertEquals(round($currentAccounts->sum('balance'), 3), $month['amount']);
            }

            $this->assertEquals($startMonth->format('M'), $month['period']);
            $startMonth->addMonth();
        }
    }
}
