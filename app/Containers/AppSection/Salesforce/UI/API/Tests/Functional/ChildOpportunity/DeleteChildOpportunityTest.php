<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class DeleteChildOpportunityTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/salesforce/child_opportunity/{salesforce_id}';

    /**
     * @test
     */
    public function testDeleteSalesforceAccount(): void
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

        $response = $this->injectId($childOpportunity->salesforce_id, true, '{salesforce_id}')->makeCall();

        $response->assertSuccessful();

        $this->assertDatabaseMissing('salesforce_child_opportunities', [
            'id' => $childOpportunity->getKey(),
        ]);

        Http::assertSent(function (Request $request) use ($childOpportunity): bool {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            $urlPattern = sprintf('%s/services/data/v%s/sobjects/Child_Opportunity__c/%s', $this->fakeUrl, $this->apiVer, $childOpportunity->salesforce_id);

            return $urlPattern === $request->url();
        });
    }
}
