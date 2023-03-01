<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tests\Unit;

use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Events\Handlers\SalesforceUpdateChildOpportunityEventHandler;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

/**
 * Class CalculateTotalTest.
 *
 * @group AssetsConsolidations
 * @group unit
 */
class ChildOpportunityUpdateTest extends TestCase
{
    /**
     * @test
     */
    public function testChildOpportunityUpdate(): void
    {
        $user          = $this->getTestingUser();
        $member        = $this->registerMember($user->getKey());
        $opportunityId = $this->createOpportunity($member->getKey());
        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity = SalesforceChildOpportunity::factory()->create([
            'member_id'                 => $member->getKey(),
            'user_id'                   => $user->getKey(),
            'salesforce_opportunity_id' => $opportunityId,
        ]);
        $childOpportunity = SalesforceChildOpportunity::with(['opportunity', 'opportunity.account', 'user.salesforce'])->find($childOpportunity->id);

        $event = new SalesforceUpdateChildOpportunityEvent($childOpportunity->salesforce_id);
        /** @var SalesforceUpdateChildOpportunityEventHandler $eventHandler */
        $eventHandler = app(SalesforceUpdateChildOpportunityEventHandler::class);
        $eventHandler->handle($event);
        Http::assertSent(function (Request $request) use ($childOpportunity): bool {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            $urlPattern = sprintf('%s/services/data/v%s/sobjects/Child_Opportunity__c/%s', $this->fakeUrl, $this->apiVer, $childOpportunity->salesforce_id);
            $this->assertEquals($urlPattern, $request->url());
            $baseData = [
                'Client_Account__c'             => $childOpportunity->opportunity->account->salesforce_id,
                'Opportunity_Amount__c'         => $childOpportunity->amount,
                'Close_Date__c'                 => $childOpportunity->close_date->format('Y-m-d'),
                'Name'                          => $childOpportunity->name,
                'Child_Opportunity_Stage__c'    => $childOpportunity->stage,
                'Type__c'                       => $childOpportunity->type,
                'Parent_Opportunity__c'         => $childOpportunity->opportunity->salesforce_id,
                'Child_Opportunity_Owner__c'    => $childOpportunity->user->salesforce->salesforce_id,
            ];

            $this->assertEmpty(array_diff($baseData, $request->data()));

            return true;
        });
    }
}
