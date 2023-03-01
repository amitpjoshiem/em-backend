<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tests;

use App\Containers\AppSection\Member\Tests\Traits\RegisterMemberTestTrait;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Ship\Parents\Tests\PhpUnit\TestCase as ShipTestCase;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Class TestCase.
 *
 * Container TestCase class. Use this class to put your container specific tests helper functions.
 */
class TestCase extends ShipTestCase
{
    use RegisterMemberTestTrait;

    private mixed $realHttp;

    public string $fakeUrl = 'http://salesforce';

    public string $fakeUserId;

    public string $fakeSalesforceId;

    public string $loginUrl;

    public string $apiVer;

    public array $fakeChildOppData;

    public string $queryFake = '';

    public function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        $this->realHttp         = Http::getFacadeRoot();
        $this->fakeUserId       = $this->faker->uuid();
        $this->fakeSalesforceId = $this->faker->uuid();
        $this->loginUrl         = config('appSection-salesforce.login_url');
        $this->apiVer           = config('appSection-salesforce.api_version');
        $this->fakeChildOppData = [
            'CreatedById'                   => $this->fakeUserId,
            'Name'                          => $this->faker->word(),
            'Type_c'                        => $this->faker->word(),
            'Child_Opportunity_Stage__c'    => $this->faker->word(),
            'Close_Date__c'                 => $this->faker->date(),
            'Opportunity_Amount__c'         => $this->faker->randomFloat(3, max: 99999),
            'CreatedDate'                   => $this->faker->date(),
        ];

        /** @psalm-suppress InvalidArrayOffset */
        Http::fake([
            $this->loginUrl => Http::response([
                'access_token'  => Str::uuid(),
                'instance_url'  => $this->fakeUrl,
                'id'            => sprintf('https://test.salesforce.com/id/00D010000008kVaEAI/%s', $this->fakeUserId),
                'token_type'    => 'Bearer',
                'issued_at'     => Carbon::now()->addMinutes(5)->timestamp,
                'signature'     => Str::uuid(),
            ]),
            sprintf('%s/services/data/v%s/sobjects/*/', $this->fakeUrl, $this->apiVer) => Http::response([
                'success'   => true,
                'id'        => $this->fakeSalesforceId,
            ]),
            sprintf('%s/services/data/v%s/sobjects/Child_Opportunity__c/', $this->fakeUrl, $this->apiVer) => Http::response([
                'success'   => true,
                'id'        => $this->fakeSalesforceId,
            ]),
            sprintf('%s/services/data/v%s/sobjects/Account/*', $this->fakeUrl, $this->apiVer) => Http::response([]),
            sprintf('%s/services/data/v%s/sobjects/Child_Opportunity__c/*', $this->fakeUrl, $this->apiVer) => Http::response([
                'CreatedById'                   => $this->fakeUserId,
                'Name'                          => 'TestName',
                'Type_c'                        => 'TestType',
                'Child_Opportunity_Stage__c'    => 'TestStage',
            ]),
            sprintf('%s/services/data/v%s/query/*', $this->fakeUrl, $this->apiVer) => Http::response([
                'totalSize' => '0',
                'records'   => [
                    [],
                ],
            ]),
        ]);
    }

    public function tearDown(): void
    {
        Cache::flush();
        Http::swap($this->realHttp);
        parent::tearDown();
    }

    protected function assertAuthSendRequest(Request $request): bool
    {
        $data = $request->data();
        $this->assertEquals('password', $data['grant_type']);
        $this->assertEquals(config('appSection-salesforce.clientId'), $data['client_id']);
        $this->assertEquals(config('appSection-salesforce.clientSecret'), $data['client_secret']);
        $this->assertEquals(config('appSection-salesforce.username'), $data['username']);
        $this->assertEquals(config('appSection-salesforce.password'), $data['password']);

        return true;
    }

    public SalesforceUser $salesforceUser;

    public function createOpportunity(int $memberId): int
    {
        /** @var SalesforceUser $user */
        $user = SalesforceUser::factory()->create([
            'user_id'       => $this->testingUser?->getKey(),
            'salesforce_id' => $this->fakeUserId,
        ]);

        $this->salesforceUser = $user;

        $account = SalesforceAccount::factory()->create([
            'member_id'     => $memberId,
        ]);

        $opportunity = SalesforceOpportunity::factory()->create([
            'member_id'              => $memberId,
            'salesforce_account_id'  => $account->getKey(),
        ]);

        return $opportunity->getKey();
    }
}
