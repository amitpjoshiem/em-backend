<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Containers\AppSection\Member\Models\MemberOther;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Collection;

class GetMembersInfoTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/members';

    /**
     * @var int
     */
    private const COUNT_MEMBERS = 10;

    /**
     * @test
     */
    public function testGetAllAdvisorMembersInfo(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @noRector \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector */
        for ($i = 0; $i < self::COUNT_MEMBERS; $i++) {
            $this->registerMember($user->getKey(), true);
        }

        $response = $this->makeCall();

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(self::COUNT_MEMBERS, $content['data']);
    }

    public function testGetAllAdvisorProspectsInfo(): void
    {
        $countMembers = 10;
        /** @var Collection $members */
        $members      = Member::factory()->count($countMembers)->make();

        $members->map(function (Member $member): void {
            $member->married = false;
        });

        /** @var User $user */
        $user = $this->getTestingUser();

        $user->members()->saveMany($members);

        $user->members->map(function (Member $member): void {
            /** @var MemberHouse $memberHouse */
            $memberHouse = MemberHouse::factory()->make();
            $member->house()->save($memberHouse);

            /** @var MemberOther $memberOther */
            $memberOther = MemberOther::factory()->make();
            $member->house()->save($memberOther);
        });

        $prospects = Member::query()
            ->where('user_id', $user->id)
            ->where('type', Member::PROSPECT)
            ->get();

        $response = $this->makeCall([
            'search'  => 'type:' . Member::PROSPECT,
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount($prospects->count(), $content['data']);
    }

    public function testGetAllAdvisorClientsInfo(): void
    {
        $countMembers = 10;
        /** @var Collection $members */
        $members      = Member::factory()->count($countMembers)->make();

        $members->map(function (Member $member): void {
            $member->married = false;
        });

        /** @var User $user */
        $user = $this->getTestingUser();

        $user->members()->saveMany($members);

        $user->members->map(function (Member $member): void {
            /** @var MemberHouse $memberHouse */
            $memberHouse = MemberHouse::factory()->make();
            $member->house()->save($memberHouse);

            /** @var MemberOther $memberOther */
            $memberOther = MemberOther::factory()->make();
            $member->house()->save($memberOther);
        });

        $clients = Member::query()
            ->where('user_id', $user->id)
            ->where('type', Member::CLIENT)
            ->get();

        $response = $this->makeCall([
            'search'  => 'type:' . Member::CLIENT,
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount($clients->count(), $content['data']);
    }

    public function testShowSoftDeleteForAdmin(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        app(AssignUserToRolesSubAction::class)->run($user, ['admin']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $member->delete();

        $response = $this->makeCall(['type' => 'all']);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(1, $content['data']);

        $this->assertArrayHasKey('deleted_at', $content['data'][0]);
    }

    public function testShowSoftDeleteForAdvisor(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        app(AssignUserToRolesSubAction::class)->run($user, ['advisor']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $member->delete();

        $response = $this->makeCall(['type' => 'all']);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(0, $content['data']);
    }
}
