<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\Authorization\Tasks\AssignUserToRolesTask;
use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class GetAllUsersTest.
 *
 * @group user
 * @group api
 */
class GetAllAdminsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/admins';

    protected array $access = [
        'roles'       => '',
        'permissions' => UserPermissionEnum::LIST,
    ];

    /**
     * @test
     */
    public function testGetAllAdmins(): void
    {
        // should not be returned
        User::factory()->count(2)->create();

        // create some admin user
        /** @var User $user */
        $user = User::factory()->create();

        $user->markEmailAsVerified();

        app(AssignUserToRolesTask::class)->run($user, ['admin']);

        app(UpdateUserTask::class)->run(['last_login_at' => now()], $user->id);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        // assert the returned data size is correct
        // 1 (fake in this test) + 1 (seeded super user/admin)
        $this->assertCount(2, $responseContent->data);
    }

    /**
     * @test
     */
    public function testGetAllAdminsByNonAdmin(): void
    {
        $this->getTestingUserWithoutAccess();

        // create some fake users
        User::factory()->create();

        // send the HTTP request
        $response = $this->makeCall();
        // assert response status is correct
        $response->assertStatus(403);

        $this->assertResponseContainKeyValue([
            'message' => 'This action is unauthorized.',
        ]);
    }
}
