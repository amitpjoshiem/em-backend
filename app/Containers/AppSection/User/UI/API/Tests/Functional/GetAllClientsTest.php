<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class GetAllUsersTest.
 *
 * @group user
 * @group api
 */
class GetAllClientsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/clients';

    protected array $access = [
        'roles'       => '',
        'permissions' => UserPermissionEnum::LIST,
    ];

    /**
     * @test
     */
    public function testGetAllClientsByAdmin(): void
    {
        // should not be returned
        User::factory()->count(3)->create();

        // should be returned
        /** @var User $user */
        $user = User::factory()->create();

        app(AssignUserToRolesTask::class)->run($user, ['advisor']);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        // assert the returned data size is correct
        // 1 (fake in this test) + 6 (seeded user)
        $this->assertCount(7, $responseContent->data);
    }

    /**
     * @test
     */
    public function testGetAllClientsByNonAdmin(): void
    {
        // prepare a user without any roles or permissions
        $this->getTestingUserWithoutAccess();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(403);

        $this->assertResponseContainKeyValue([
            'message' => 'This action is unauthorized.',
        ]);
    }
}
