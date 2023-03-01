<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\ChildOpportunity;

use App\Containers\AppSection\Activity\Events\Events\MemberChildOpportunityAddedEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;

class CreateChildOpportunityTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/salesforce/child_opportunity';

    /**
     * @test
     */
    public function testCreateChildOpportunity(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $opportunityId = $this->createOpportunity($member->getKey());

        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity = SalesforceChildOpportunity::factory()->make([
            'member_id'                 => $member->getKey(),
            'salesforce_opportunity_id' => $opportunityId,
        ]);

        $response = $this->makeCall([
            'member_id'     => $member->getHashedKey(),
            'salesforce_id' => $this->fakeSalesforceId,
            'type'          => $childOpportunity->type,
            'stage'         => $childOpportunity->stage,
            'close_date'    => $childOpportunity->close_date->format('Y-m-d'),
            'amount'        => $childOpportunity->amount,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('salesforce_child_opportunities', [
            'member_id'                 => $member->getKey(),
            'stage'                     => $childOpportunity->stage,
            'amount'                    => $childOpportunity->amount,
            'salesforce_opportunity_id' => $opportunityId,
            'type'                      => $childOpportunity->type,
            'close_date'                => $childOpportunity->close_date->format('Y-m-d'),
            'user_id'                   => $user->getKey(),
        ]);

        Http::assertSent(function (Request $request) use ($member, $childOpportunity): bool {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            if (str_contains($request->url(), $this->fakeSalesforceId)) {
                $urlPattern = sprintf('%s/services/data/v%s/sobjects/Child_Opportunity__c/%s', $this->fakeUrl, $this->apiVer, $this->fakeSalesforceId);
                $this->assertEquals($urlPattern, $request->url());
            } else {
                $urlPattern = sprintf('%s/services/data/v%s/sobjects/Child_Opportunity__c/', $this->fakeUrl, $this->apiVer);
                $this->assertEquals($urlPattern, $request->url());
                $baseData = [
                    'Client_Account__c'          => $member->salesforce->salesforce_id,
                    'Opportunity_Amount__c'      => $childOpportunity->amount,
                    'Close_Date__c'              => $childOpportunity->close_date->format('Y-m-d'),
                    'Child_Opportunity_Stage__c' => $childOpportunity->stage,
                    'Type__c'                    => $childOpportunity->type,
                    'Child_Opportunity_Owner__c' => $this->salesforceUser->salesforce_id,
                ];
                $this->assertEmpty(array_diff($baseData, $request->data()));
            }

            return true;
        });
        Event::assertDispatched(MemberChildOpportunityAddedEvent::class);
    }
}
