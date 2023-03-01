<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class DeleteUserTest.
 *
 * @group user
 * @group api
 */
class DeleteUserTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/users/{id}';

    protected array $access = [
        'roles'       => '',
        'permissions' => UserPermissionEnum::DELETE,
    ];

    /**
     * @test
     */
    public function testDeleteExistingUser(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        // Send the HTTP request
        $response = $this->injectId($user->id)->makeCall();

        // Assert response status is correct
        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function testDeleteAnotherExistingUser(): void
    {
        // Make the call form the user token who has no access
        $this->getTestingUserWithoutAccess();

        /** @var User $anotherUser */
        $anotherUser = User::factory()->create();

        // Send the HTTP request
        $response = $this->injectId($anotherUser->id)->makeCall();

        // Assert response status is correct
        $response->assertStatus(403);
    }
}
