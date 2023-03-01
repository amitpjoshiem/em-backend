<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\Accounts;

use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class UpdateAccountTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/salesforce/account/{member_id}';

    /**
     * @test
     */
    public function testUpdateSalesforceAccount(): void
    {
        $user = $this->getTestingUser();
        SalesforceUser::factory()->create(['user_id' => $user->getKey()]);

        $member = $this->registerMember($user->getKey());

        SalesforceAccount::factory()->create([
            'member_id' => $member->getKey(),
        ]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

        $response->assertSuccessful();

        Http::assertSent(function (Request $request) use ($member): bool {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            $urlPattern = sprintf('%s/services/data/v%s/sobjects/Account/%s', $this->fakeUrl, $this->apiVer, $member->salesforce->salesforce_id);
            $this->assertEquals($urlPattern, $request->url());
            $baseData = [
                'Name'                      => $member->name,
                'Client_Email_Primary__c'   => $member->email,
                'Phone'                     => $member->phone,
                'Type'                      => $member->type,
                'BillingStreet'             => $member->address,
                'BillingState'              => $member->state,
                'BillingCity'               => $member->city,
                'BillingCountry'            => 'USA',
                'BillingPostalCode'         => $member->zip,
            ];

            $this->assertEmpty(array_diff($baseData, $request->data()));

            return true;
        });
    }
}
