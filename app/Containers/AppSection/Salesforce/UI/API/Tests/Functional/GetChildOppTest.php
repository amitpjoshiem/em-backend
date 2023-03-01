<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;

class GetChildOppTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/salesforce/child_opportunity/all/{member_id}';

    /**
     * @test
     */
    public function testGetChildOpp(): void
    {
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $count     = 100;
        $childOpps = SalesforceChildOpportunity::factory()->count($count)->create([
            'member_id' => $member->getKey(),
            'user_id'   => $user->getKey(),
        ]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertCount($count, $data);
        foreach ($data as $key => $childOpp) {
            /** @var SalesforceChildOpportunity $sourceChildOpp */
            $sourceChildOpp = $childOpps->get($key);
            $this->assertEmpty(array_diff([
                'id'            => $sourceChildOpp->salesforce_id,
                'name'          => $sourceChildOpp->name,
                'created_date'  => $sourceChildOpp->created_at->toDateString(),
                'amount'        => $sourceChildOpp->amount,
                'type'          => $sourceChildOpp->type,
                'stage'         => $sourceChildOpp->stage,
                'close_date'    => $sourceChildOpp->close_date->toDateString(),
            ], $childOpp));
        }
    }
}
