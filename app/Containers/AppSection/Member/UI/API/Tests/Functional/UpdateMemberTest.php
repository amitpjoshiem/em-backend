<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Events\Events\UpdateMemberEvent;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Hashids;
use Illuminate\Support\Facades\Event;

class UpdateMemberTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/members/{id}';

    /**
     * @test
     */
    public function testUpdateMemberWithSpouse(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $data = $this->getMemberRegisterData(true);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $data['spouse']['employment_history'] = MemberEmploymentHistory::factory()->count($member->spouse->employmentHistory->count())->make()->toArray();

        foreach ($data['spouse']['employment_history'] as $key => &$history) {
            $history['id'] = $member->spouse->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $memberId = Hashids::decode($content['data']['id'])[0];

        $spouseId = Hashids::decode($content['data']['spouse']['id'])[0];

        $this->assertDatabaseHas('members', [
            'email'             => $data['email'],
            'name'              => $data['name'],
            'type'              => $data['type'],
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

        unset($history);
        foreach ($data['employment_history'] as $history) {
            $this->assertDatabaseHas('member_employment_histories', [
                'id'                => Hashids::decode($history['id'])[0],
                'company_name'      => $history['company_name'],
                'occupation'        => $history['occupation'],
                'years'             => $history['years'],
                'memberable_id'     => $memberId,
                'memberable_type'   => Member::class,
            ]);
        }

        foreach ($data['spouse']['employment_history'] as $spouseHistory) {
            $this->assertDatabaseHas('member_employment_histories', [
                'id'                => Hashids::decode($spouseHistory['id'])[0],
                'company_name'      => $spouseHistory['company_name'],
                'occupation'        => $spouseHistory['occupation'],
                'years'             => $spouseHistory['years'],
                'memberable_id'     => $spouseId,
                'memberable_type'   => MemberContact::class,
            ]);
        }

        Event::assertDispatched(UpdateMemberEvent::class);
    }

    /**
     * @test
     */
    public function testUpdateMemberWithoutSpouse(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), false);

        $data = $this->getMemberRegisterData(false);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $memberId = Hashids::decode($content['data']['id'])[0];

        $this->assertEmpty($content['data']['spouse']);

        $this->assertDatabaseHas('members', [
            'email'             => $data['email'],
            'name'              => $data['name'],
            'type'              => $data['type'],
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

        unset($history);
        foreach ($data['employment_history'] as $history) {
            $this->assertDatabaseHas('member_employment_histories', [
                'id'                => Hashids::decode($history['id'])[0],
                'company_name'      => $history['company_name'],
                'occupation'        => $history['occupation'],
                'years'             => $history['years'],
                'memberable_id'     => $memberId,
                'memberable_type'   => Member::class,
            ]);
        }

        Event::assertDispatched(UpdateMemberEvent::class);
    }

    /**
     * @test
     */
    public function testUpdateNonValidMemberData(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), false);

        $data = $this->getMemberRegisterData(false);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $data['name']            = 123;
        $data['email']           = 'I`m not valid email';
        $data['birthday']        = 'i`m not valid date';
        $data['phone']           = '380987654321';
        $data['married']         = 'true';
        $data['retired']         = 'false';
        $data['retirement_date'] = 'i`m not valid date';
        $data['address']         = true;
        $data['city']            = 11_111_111;
        $data['state']           = false;
        $data['zip']             = 11111;

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $this->assertValidationErrorContain([
            'name'            => 'The name must be a string.',
            'email'           => 'The email must be a valid email address.',
            'birthday'        => 'The birthday is not a valid date.',
            'phone'           => 'The phone format is invalid.',
            'married'         => 'The married field must be true or false.',
            'retired'         => 'The retired field must be true or false.',
            'retirement_date' => 'The retirement date is not a valid date.',
            'address'         => 'The address must be a string.',
            'city'            => 'The city must be a string.',
            'state'           => 'The state must be a string.',
            'zip'             => 'The zip must be a string.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateNonValidSpouseData(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $data = $this->getMemberRegisterData(true);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $data['spouse']['name']            = 123;
        $data['spouse']['email']           = 'I`m not valid email';
        $data['spouse']['birthday']        = 'i`m not valid date';
        $data['spouse']['phone']           = '380987654321';
        $data['spouse']['retired']         = 'false';
        $data['spouse']['retirement_date'] = 'i`m not valid date';

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $this->assertValidationErrorContain([
            'spouse.name'            => 'The spouse.name must be a string.',
            'spouse.email'           => 'The spouse.email must be a valid email address.',
            'spouse.birthday'        => 'The spouse.birthday is not a valid date.',
            'spouse.phone'           => 'The spouse.phone format is invalid.',
            'spouse.retired'         => 'The spouse.retired field must be true or false.',
            'spouse.retirement_date' => 'The spouse.retirement date is not a valid date.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateNonValidHouseData(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $data = $this->getMemberRegisterData(true);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $data['house']['type']                      = 'wrong_type';
        $data['house']['market_value']              = 99999;
        $data['house']['total_debt']                = 99999;
        $data['house']['remaining_mortgage_amount'] = 99999;
        $data['house']['monthly_payment']           = 99999;
        $data['house']['total_monthly_expenses']    = 99999;

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $this->assertValidationErrorContain([
            'house.type'                      => 'The selected house.type is invalid.',
            'house.market_value'              => 'The house.market value must be a string.',
            'house.total_debt'                => 'The house.total debt must be a string.',
            'house.remaining_mortgage_amount' => 'The house.remaining mortgage amount must be a string.',
            'house.monthly_payment'           => 'The house.monthly payment must be a string.',
            'house.total_monthly_expenses'    => 'The house.total monthly expenses must be a string.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateNonValidOtherData(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $data = $this->getMemberRegisterData(true);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $data['other']['risk_tolerance']        = 'wrong_risk';
        $data['other']['questions']             = 99999;
        $data['other']['retirement_goal']       = 99999;
        $data['other']['retirement_money_goal'] = 99999;
        $data['other']['work_with_advisor']     = 'true';

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $this->assertValidationErrorContain([
            'other.risk_tolerance'        => 'The selected other.risk tolerance is invalid.',
            'other.questions'             => 'The other.questions must be a string.',
            'other.retirement_goal'       => 'The other.retirement goal must be a string.',
            'other.retirement_money_goal' => 'The other.retirement money goal must be a string.',
            'other.work_with_advisor'     => 'The other.work with advisor field must be true or false.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateNonValidEmploymentHistoryData(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $data = $this->getMemberRegisterData(true);

        $data['employment_history'] = MemberEmploymentHistory::factory()->count($member->employmentHistory->count())->make()->toArray();

        foreach ($data['employment_history'] as $key => &$history) {
            $history['id'] = $member->employmentHistory->offsetGet($key)->getHashedKey();
        }

        $data['employment_history'][0]['company_name']           = 99999;
        $data['employment_history'][0]['occupation']             = 99999;
        $data['employment_history'][0]['years']                  = 'NaN';
        $data['spouse']['employment_history'][0]['company_name'] = 99999;
        $data['spouse']['employment_history'][0]['occupation']   = 99999;
        $data['spouse']['employment_history'][0]['years']        = 'NaN';

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
        $this->assertValidationErrorContain([
            'employment_history.0.company_name'        => 'The employment_history.0.company_name must be a string.',
            'employment_history.0.occupation'          => 'The employment_history.0.occupation must be a string.',
            'employment_history.0.years'               => 'The employment_history.0.years must be an integer.',
            'spouse.employment_history.0.company_name' => 'The spouse.employment_history.0.company_name must be a string.',
            'spouse.employment_history.0.occupation'   => 'The spouse.employment_history.0.occupation must be a string.',
            'spouse.employment_history.0.years'        => 'The spouse.employment_history.0.years must be an integer.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateNewEmploymentHistoryData(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $memberEmploymentsHistory = MemberEmploymentHistory::factory()->make()->toArray();
        $spouseEmploymentsHistory = MemberEmploymentHistory::factory()->make()->toArray();

        $data = [
            'employment_history'    => [
                $memberEmploymentsHistory,
            ],
            'spouse'                => [
                'employment_history'    => [
                    $spouseEmploymentsHistory,
                ],
            ],
        ];

        $response = $this->injectId($member->id)->makeCall($data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('member_employment_histories', array_merge($memberEmploymentsHistory, [
            'memberable_id'     => $member->getKey(),
            'memberable_type'   => Member::class,
        ]));
        $this->assertDatabaseHas('member_employment_histories', array_merge($spouseEmploymentsHistory, [
            'memberable_id'     => $member->spouse->getKey(),
            'memberable_type'   => MemberContact::class,
        ]));
    }
}
