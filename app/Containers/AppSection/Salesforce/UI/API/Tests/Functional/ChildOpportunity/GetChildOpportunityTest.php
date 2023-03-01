<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;

class GetChildOpportunityTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/salesforce/child_opportunity/find/{id}';

    /**
     * @test
     */
    public function testGetSalesforceAccount(): void
    {
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $opportunityId = $this->createOpportunity($member->getKey());

        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity = SalesforceChildOpportunity::factory()->create([
            'member_id'                 => $member->getKey(),
            'salesforce_opportunity_id' => $opportunityId,
            'user_id'                   => $user->getKey(),
        ]);

        $response = $this->injectId($childOpportunity->salesforce_id, true)->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];

        $baseData = [
            'id'            => $childOpportunity->salesforce_id,
            'name'          => $childOpportunity->name,
            'created_date'  => $childOpportunity->created_at->format('Y-m-d'),
            'amount'        => $childOpportunity->amount,
            'type'          => $childOpportunity->type,
            'stage'         => $childOpportunity->stage,
            'close_date'    => $childOpportunity->close_date->format('Y-m-d'),
        ];

        $this->assertEmpty(array_diff($baseData, $data));
    }
}
