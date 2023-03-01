<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\ChildOpportunity;

use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUpdateChildOpportunityEvent;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Event;

class UpdateChildOpportunityTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/salesforce/child_opportunity/{id}';

    /**
     * @test
     */
    public function testUpdateChildOpportunityAccount(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $opportunityId = $this->createOpportunity($member->getKey());

        /** @var SalesforceChildOpportunity $childOpportunity */
        $childOpportunity = SalesforceChildOpportunity::factory()->create([
            'member_id'                 => $member->getKey(),
            'salesforce_opportunity_id' => $opportunityId,
            'user_id'                   => $user->getKey(),
        ]);

        /** @var SalesforceChildOpportunity $newChildOpportunityData */
        $newChildOpportunityData = SalesforceChildOpportunity::factory()->make([
            'member_id'                 => $member->getKey(),
            'salesforce_opportunity_id' => $opportunityId,
            'user_id'                   => $user->getKey(),
        ]);

        $response = $this->injectId($childOpportunity->salesforce_id, true)->makeCall([
            'type'          => $newChildOpportunityData->type,
            'stage'         => $newChildOpportunityData->stage,
            'close_date'    => $newChildOpportunityData->close_date->format('Y-m-d'),
            'amount'        => (string)$newChildOpportunityData->amount,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('salesforce_child_opportunities', [
            'member_id'                 => $member->getKey(),
            'stage'                     => $newChildOpportunityData->stage,
            'amount'                    => $newChildOpportunityData->amount,
            'salesforce_opportunity_id' => $opportunityId,
            'type'                      => $newChildOpportunityData->type,
            'close_date'                => $newChildOpportunityData->close_date->format('Y-m-d'),
            'user_id'                   => $user->getKey(),
        ]);

        Event::assertDispatched(SalesforceUpdateChildOpportunityEvent::class);
    }
}
