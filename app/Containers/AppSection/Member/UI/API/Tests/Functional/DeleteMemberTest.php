<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\SubActions\AssignUserToRolesSubAction;
use App\Containers\AppSection\Member\Events\Events\DeleteMemberEvent;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Event;

class DeleteMemberTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/members/{id}';

    /**
     * @test
     */
    public function testAdminDeleteMember(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        app(AssignUserToRolesSubAction::class)->run($user, ['admin']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(204);

        $this->assertSoftDeleted('members', [
            'id' => $member->id,
        ]);

        Event::assertDispatched(DeleteMemberEvent::class);
    }

    public function testAdvisorDeleteMember(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        app(AssignUserToRolesSubAction::class)->run($user, ['advisor']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(403);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('This action is unauthorized.', $content['message']);
    }
}
