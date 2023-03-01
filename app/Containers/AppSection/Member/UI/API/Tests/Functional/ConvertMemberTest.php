<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Event;

class ConvertMemberTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/members/convert/{id}';

    /**
     * @test
     */
    public function testConvertToClient(): void
    {
        Event::fake();
        /** @var User $user */
        $user = $this->getTestingUser();

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', [
            'id'    => $member->id,
            'type'  => Member::CLIENT,
        ]);
    }

    public function testConvertToClientNotOwner(): void
    {
        $user = $this->getTestingUser(['email' => 'owner@owner.com']);

        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $this->getTestingUser(['email' => 'advisor@advisor.com']);

        $response = $this->injectId($member->id)->makeCall();

        $response->assertStatus(403);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals('This action is unauthorized.', $content['message']);
    }
}
