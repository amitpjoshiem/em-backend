<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class GetMemberCountTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/pipeline/member/statistics/count';

    /**
     * @test
     */
    public function testGetAUM(): void
    {
        $user = $this->getTestingUser();

        $memberCount = 50;
        $members     = Member::factory()->count($memberCount)->create([
            'user_id'   => $user->getKey(),
        ])->filter(static function (Member $member): bool {
            return $member->created_at->gte(now()->subMonths(11)->startOfMonth());
        })->groupBy(static function (Member $member): string {
            return $member->created_at->format('Y-m');
        });

        $response = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data       = $content['data'];
        $startMonth = now()->subMonths(11);
        foreach ($data as $month) {
            /** @var Collection | null $currentMembers */
            $currentMembers = $members->get($startMonth->format('Y-m'));

            if ($currentMembers === null) {
                $this->assertEquals(0, $month['count']);
            } else {
                $this->assertEquals($currentMembers->count(), $month['count']);
            }

            $this->assertEquals($startMonth->format('M'), $month['period']);
            $startMonth->addMonth();
        }
    }
}
