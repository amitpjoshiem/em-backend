<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Tests\Functional;

use App\Containers\AppSection\Dashboard\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;

/**
 * Class MemberListTest.
 *
 * @group init
 * @group api
 */
class MemberListTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/dashboard/members/list';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testGetEmptyMemberList(): void
    {
        $this->getTestingUser();

        $response = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        $this->assertEmpty($data);
    }

    /**
     * @test
     */
    public function testGetMemberList(): void
    {
        $user = $this->getTestingUser();

        $childOpps = collect();
        Member::factory()->count(20)->create(['user_id' => $user->getKey()])->each(function (Member $member) use (&$childOpps): void {
            $childOpps = $childOpps->merge(SalesforceChildOpportunity::factory()->count(5)->create([
                'user_id'   => $member->user_id,
                'member_id' => $member->getKey(),
            ]));
        });
        $childOpps = $childOpps->sortByDesc('amount')->take(config('appSection-dashboard.member_list_count'))->values();
        $response  = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];

        $this->assertCount(config('appSection-dashboard.member_list_count'), $data);
        /**
         * @var int                        $key
         * @var SalesforceChildOpportunity $childOpp
         */
        foreach ($childOpps as $key => $childOpp) {
            $this->assertEmpty(array_diff([
                'name'      => $childOpp->member->name,
                'type'      => $childOpp->member->type,
                'stage'     => $childOpp->stage,
                'amount'    => $childOpp->amount,
            ], $data[$key]));
        }
    }
}
