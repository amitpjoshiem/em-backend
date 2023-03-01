<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\Accounts;

use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class CreateAccountTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/salesforce/account';

    /**
     * @test
     */
    public function testCreateAccount(): void
    {
        $user = $this->getTestingUser();
        SalesforceUser::factory()->create(['user_id' => $user->getKey()]);

        $member = $this->registerMember($user->getKey(), false);

        $response = $this->makeCall([
            'member_id'     => $member->getHashedKey(),
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('salesforce_accounts', [
            'member_id'     => $member->getKey(),
            'salesforce_id' => $this->fakeSalesforceId,
        ]);

        Http::assertSent(function (Request $request) use ($member): bool {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            if (str_contains($request->url(), 'sobjects')) {
                $baseData = [];
                preg_match("#.*\/sobjects\/(.*)\/#", $request->url(), $object);

                if ($object[1] === 'Account') {
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
                } elseif ($object[1] === 'Opportunity') {
                    $baseData = [
                        'AccountId' => $member->salesforce->salesforce_id,
                        'Name'      => $member->name,
                        'CloseDate' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                        'StageName' => 'Prospect',
                    ];
                }

                $this->assertEmpty(array_diff($baseData, $request->data()));

                return true;
            }

            return true;
        });
    }

    public function testCreateAccountWithoutSalesforceUser(): void
    {
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey(), false);

        $response = $this->makeCall([
            'member_id' => $member->getHashedKey(),
        ]);

        $response->assertStatus(400);

        $this->assertResponseContainKeyValue([
            'message' => 'User does not login to salesforce',
        ]);
    }
}
