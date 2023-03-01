<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional\Accounts;

use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class DeleteAccountTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/salesforce/account/{member_id}';

    /**
     * @test
     */
    public function testDeleteSalesforceAccount(): void
    {
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        SalesforceAccount::factory()->create([
            'member_id' => $member->getKey(),
        ]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

        $response->assertSuccessful();

        $this->assertDatabaseMissing('salesforce_accounts', [
            'member_id' => $member->getKey(),
        ]);

        Http::assertSent(function (Request $request) use ($member): bool {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            $urlPattern = sprintf('%s/services/data/v%s/sobjects/Account/%s', $this->fakeUrl, $this->apiVer, $member->salesforce->salesforce_id);

            return $urlPattern === $request->url();
        });
    }
}
