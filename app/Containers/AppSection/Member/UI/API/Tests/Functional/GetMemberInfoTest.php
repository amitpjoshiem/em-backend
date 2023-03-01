<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class GetMemberInfoTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/members/{id}';

    /**
     * @test
     */
    public function testGetMemberInfo(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey(), true);

        $response = $this->injectId($member->getKey())->makeCall();

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($member->getHashedKey(), $content['data']['id']);

        $memberArray = $member->toArray();

        $missedKeys = [
            'id',
            'age',
            'onboarding',
        ];
        foreach ($content['data'] as $key => $field) {
            if (\in_array($key, $missedKeys, true)) {
                continue;
            }

            if (!\is_array($field)) {
                $this->assertEquals($field, $memberArray[$key]);
            }
        }

        $this->assertEquals($member->spouse->getHashedKey(), $content['data']['spouse']['id']);
        foreach ($content['data']['spouse'] as $key => $field) {
            if (\in_array($key, $missedKeys, true)) {
                continue;
            }

            if (!\is_array($field)) {
                $this->assertEquals($field, $memberArray['spouse'][$key]);
            }
        }

        $this->assertEquals($member->house->getHashedKey(), $content['data']['house']['id']);
        foreach ($content['data']['house'] as $key => $field) {
            if ($key === 'id') {
                continue;
            }

            if (!\is_array($field)) {
                $this->assertEquals($field, $memberArray['house'][$key]);
            }
        }

        $this->assertEquals($member->other->getHashedKey(), $content['data']['other']['id']);
        foreach ($content['data']['other'] as $key => $field) {
            if ($key === 'id') {
                continue;
            }

            if (!\is_array($field)) {
                $this->assertEquals($field, $memberArray['other'][$key]);
            }
        }

        /** @var MemberEmploymentHistory $employmentHistory */
        $employmentHistory          = $member->employmentHistory->sortByDesc('updated_at');
        $comparingEmploymentHistory = [];
        $employmentHistory->each(function (MemberEmploymentHistory $employmentHistory) use (&$comparingEmploymentHistory): void {
            $comparingEmploymentHistory[] = $this->getComparingEmploymentHistory($employmentHistory);
        });
        $this->assertTrue($comparingEmploymentHistory === $content['data']['employment_history']);

        /** @var MemberEmploymentHistory $employmentHistory */
        $spouseEmploymentHistory          = $member->spouse->employmentHistory->sortByDesc('updated_at');
        $comparingSpouseEmploymentHistory = [];
        $spouseEmploymentHistory->each(function (MemberEmploymentHistory $employmentHistory) use (&$comparingSpouseEmploymentHistory): void {
            $comparingSpouseEmploymentHistory[] = $this->getComparingEmploymentHistory($employmentHistory);
        });

        $this->assertTrue($comparingSpouseEmploymentHistory === $content['data']['spouse']['employment_history']);
    }

    private function getComparingEmploymentHistory(MemberEmploymentHistory $history): array
    {
        return [
            'id'            => $history->getHashedKey(),
            'company_name'  => $history->company_name,
            'occupation'    => $history->occupation,
            'years'         => $history->years,
        ];
    }

    public function testGetMemberInfoOtherAdvisor(): void
    {
        $user = $this->getTestingUser(['email' => 'owner@owner.com']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $this->getTestingUser(['email' => 'advisor@advisor.com']);

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(404);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('The requested Resource was not found.', $content['message']);
    }

    public function testShowSoftDeleteForAdmin(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        app(AssignUserToRolesSubAction::class)->run($user, ['admin']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $member->delete();

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('deleted_at', $content['data']);
    }

    public function testShowSoftDeleteForAdvisor(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        app(AssignUserToRolesSubAction::class)->run($user, ['advisor']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $member->delete();

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(404);

        $this->assertSoftDeleted('members', [
            'id'    => $member->id,
        ]);
    }
}
