<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\User\Models\User;
use Hashids;
use Illuminate\Support\Facades\Event;

class CreateMemberTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/members';

    /**
     * @test
     */
    public function testCreateMemberWithoutSalesforce(): void
    {
        Event::fake();
        /** @var User $user */
        $this->getTestingUser();

        $data = $this->getMemberRegisterData(true);

        $response = $this->makeCall($data);

        $response->assertStatus(400);

        $this->assertResponseContainKeyValue([
            'message' => 'User does not login to salesforce',
        ]);
    }

    /**
     * @test
     */
    public function testCreateMemberWithSpouse(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();
        SalesforceUser::factory()->create(['user_id' => $user->getKey()]);

        $data = $this->getMemberRegisterData(true);

        $response = $this->makeCall($data);

        $response->assertStatus(201);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $memberId = Hashids::decode($content['data']['id'])[0];

        $spouseId = Hashids::decode($content['data']['spouse']['id'])[0];

        $this->assertDatabaseHas('members', [
            'email'             => $data['email'],
            'name'              => $data['name'],
            'type'              => Member::PROSPECT,
            'retired'           => $data['retired'],
            'married'           => $data['married'],
            'phone'             => $data['phone'],
            'birthday'          => $data['birthday'],
            'retirement_date'   => $data['retirement_date'],
            'address'           => $data['address'],
            'city'              => $data['city'],
            'state'             => $data['state'],
            'zip'               => $data['zip'],
            'notes'             => $data['notes'],
            'user_id'           => $user->id,
        ]);

        $this->assertDatabaseHas('member_contacts', [
            'member_id'       => $memberId,
            'retired'         => $data['spouse']['retired'],
            'name'            => $data['spouse']['name'],
            'birthday'        => $data['spouse']['birthday'],
            'email'           => $data['spouse']['email'],
            'phone'           => $data['spouse']['phone'],
            'retirement_date' => $data['spouse']['retirement_date'],
            'is_spouse'       => true,
        ]);

        $this->assertDatabaseHas('member_houses', [
            'member_id'                 => $memberId,
            'type'                      => $data['house']['type'],
            'market_value'              => $data['house']['market_value'],
            'total_debt'                => $data['house']['total_debt'],
            'remaining_mortgage_amount' => $data['house']['remaining_mortgage_amount'],
            'monthly_payment'           => $data['house']['monthly_payment'],
            'total_monthly_expenses'    => $data['house']['total_monthly_expenses'],
        ]);

        $this->assertDatabaseHas('member_others', [
            'member_id'         => $memberId,
            'risk'              => $data['other']['risk'],
            'questions'         => $data['other']['questions'],
            'retirement'        => $data['other']['retirement'],
            'retirement_money'  => $data['other']['retirement_money'],
            'work_with_advisor' => $data['other']['work_with_advisor'],
        ]);

        foreach ($data['employment_history'] as $history) {
            $this->assertDatabaseHas('member_employment_histories', [
                'company_name'      => $history['company_name'],
                'occupation'        => $history['occupation'],
                'years'             => $history['years'],
                'memberable_id'     => $memberId,
                'memberable_type'   => Member::class,
            ]);
        }

        foreach ($data['spouse']['employment_history'] as $spouseHistory) {
            $this->assertDatabaseHas('member_employment_histories', [
                'company_name'      => $spouseHistory['company_name'],
                'occupation'        => $spouseHistory['occupation'],
                'years'             => $spouseHistory['years'],
                'memberable_id'     => $spouseId,
                'memberable_type'   => MemberContact::class,
            ]);
        }

        Event::assertDispatched(CreateMemberEvent::class);
    }

    /**
     * @test
     */
    public function testCreateMemberWithoutSpouse(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();
        SalesforceUser::factory()->create(['user_id' => $user->getKey()]);

        $data = $this->getMemberRegisterData(false);

        $response = $this->makeCall($data);

        $response->assertStatus(201);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $memberId = Hashids::decode($content['data']['id'])[0];

        $this->assertEmpty($content['data']['spouse']);

        $this->assertDatabaseHas('members', [
            'email'             => $data['email'],
            'name'              => $data['name'],
            'type'              => Member::PROSPECT,
            'retired'           => $data['retired'],
            'married'           => $data['married'],
            'phone'             => $data['phone'],
            'birthday'          => $data['birthday'],
            'retirement_date'   => $data['retirement_date'],
            'address'           => $data['address'],
            'city'              => $data['city'],
            'state'             => $data['state'],
            'zip'               => $data['zip'],
            'notes'             => $data['notes'],
            'user_id'           => $user->id,
        ]);

        $this->assertDatabaseHas('member_houses', [
            'member_id'                 => $memberId,
            'type'                      => $data['house']['type'],
            'market_value'              => $data['house']['market_value'],
            'total_debt'                => $data['house']['total_debt'],
            'remaining_mortgage_amount' => $data['house']['remaining_mortgage_amount'],
            'monthly_payment'           => $data['house']['monthly_payment'],
            'total_monthly_expenses'    => $data['house']['total_monthly_expenses'],
        ]);

        $this->assertDatabaseHas('member_others', [
            'member_id'         => $memberId,
            'risk'              => $data['other']['risk'],
            'questions'         => $data['other']['questions'],
            'retirement'        => $data['other']['retirement'],
            'retirement_money'  => $data['other']['retirement_money'],
            'work_with_advisor' => $data['other']['work_with_advisor'],
        ]);

        foreach ($data['employment_history'] as $history) {
            $this->assertDatabaseHas('member_employment_histories', [
                'company_name'      => $history['company_name'],
                'occupation'        => $history['occupation'],
                'years'             => $history['years'],
                'memberable_id'     => $memberId,
                'memberable_type'   => Member::class,
            ]);
        }

        Event::assertDispatched(CreateMemberEvent::class);
    }

    /**
     * @test
     */
    public function testCreateNonValidMemberData(): void
    {
        Event::fake();
        $this->getTestingUser();

        $data = $this->getMemberRegisterData(false);

        $requiredFields = [
            'name',
            'email',
            'birthday',
            'married',
            'retired',
        ];

        $data = $this->getNonValidData($data, $requiredFields);

        $response = $this->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);
        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey($field, $content['errors']);
        }
    }

    /**
     * @test
     */
    public function testCreateNonValidSpouseData(): void
    {
        Event::fake();
        $this->getTestingUser();

        $data = $this->getMemberRegisterData(true);

        $requiredFields = [
            'name',
            'email',
            'birthday',
            'retired',
        ];

        $data['spouse'] = $this->getNonValidData($data['spouse'], $requiredFields);

        $response = $this->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);
        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey('spouse.' . $field, $content['errors']);
        }
    }

    /**
     * @test
     */
    public function testCreateNonValidHouseData(): void
    {
        Event::fake();
        $this->getTestingUser();

        $houseNonValidData = [
            MemberHouse::RENT       => [
                'monthly_payment',
                'total_monthly_expenses',
            ],
            MemberHouse::OWN        => [
                'market_value',
                'total_debt',
                'remaining_mortgage_amount',
            ],
            MemberHouse::FAMILY     => [
                'market_value',
                'total_debt',
                'remaining_mortgage_amount',
            ],
        ];

        foreach ($houseNonValidData as $type => $requiredFields) {
            $data = $this->getMemberRegisterData(false);

            $data['house']['type'] = $type;

            $data['house'] = $this->getNonValidData($data['house'], $requiredFields);

            $response = $this->makeCall($data);

            $response->assertStatus(422);

            $this->assertResponseContainKeyValue([
                'message' => 'The given data was invalid.',
            ]);

            $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($requiredFields as $field) {
                $this->assertArrayHasKey('house.' . $field, $content['errors']);
            }
        }
    }

    /**
     * @test
     */
    public function testCreateNonValidOtherData(): void
    {
        Event::fake();
        $this->getTestingUser();

        $data = $this->getMemberRegisterData(false);

        $requiredFields = [
            'risk',
            'work_with_advisor',
        ];

        $data['other'] = $this->getNonValidData($data['other'], $requiredFields);

        $response = $this->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);
        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey('other.' . $field, $content['errors']);
        }
    }

    /**
     * @test
     */
    public function testCreateNonValidEmploymentHistoryData(): void
    {
        Event::fake();
        $this->getTestingUser();

        $data = $this->getMemberRegisterData(false);

        unset($data['employment_history'][0]['company_name'], $data['employment_history'][1]['occupation'], $data['employment_history'][2]['years']);

        $response = $this->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('employment_history.1', $content['errors']);
        $this->assertArrayHasKey('employment_history.2', $content['errors']);
    }

    private function getNonValidData(array $data, array $requiredFields): array
    {
        /** Remove Member required fields */
        foreach ($requiredFields as $field) {
            unset($data[$field]);
        }

        return $data;
    }
}
