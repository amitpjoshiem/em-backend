<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use Illuminate\Database\Eloquent\Collection;

class GetAllChildOpportunityTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/salesforce/child_opportunity/all/{member_id}';

    /**
     * @test
     */
    public function testGetAllSalesforceChildOpportunity(): void
    {
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $opportunityId = $this->createOpportunity($member->getKey());

        /** @var Collection $childOpportunity */
        $childOpportunities = SalesforceChildOpportunity::factory()->count(5)->create([
            'member_id'                 => $member->getKey(),
            'salesforce_opportunity_id' => $opportunityId,
            'user_id'                   => $user->getKey(),
        ]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];

        /** @var array $childOpportunity */
        foreach ($data as $key => $childOpportunity) {
            /** @var SalesforceChildOpportunity $baseChildOpp */
            $baseChildOpp = $childOpportunities->get($key);
            $baseData     = [
                'id'            => $baseChildOpp->salesforce_id,
                'name'          => $baseChildOpp->name,
                'created_date'  => $baseChildOpp->created_at->format('Y-m-d'),
                'amount'        => $baseChildOpp->amount,
                'type'          => $baseChildOpp->type,
                'stage'         => $baseChildOpp->stage,
                'close_date'    => $baseChildOpp->close_date->format('Y-m-d'),
            ];

            $this->assertEmpty(array_diff($baseData, $childOpportunity));
        }
    }
}
