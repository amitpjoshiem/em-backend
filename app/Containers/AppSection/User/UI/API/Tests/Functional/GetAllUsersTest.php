<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class GetAllUsersTest.
 *
 * @group user
 * @group api
 */
class GetAllUsersTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users';

    protected array $access = [
        'roles'       => 'admin',
        'permissions' => UserPermissionEnum::LIST,
    ];

    /**
     * @test
     */
    public function testGetAllUsersByAdmin(): void
    {
        // create some non-admin users who are clients
        User::factory()->count(2)->create();

        /** @var User $user */
        $user = $this->getTestingUser();
        $user->assignRole($this->access['roles']);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        // assert the returned data size is correct
        $this->assertCount(10, $responseContent->data);
    }

    /**
     * @test
     */
    public function testGetAllUsersByNonAdmin(): void
    {
        $this->getTestingUserWithoutAccess();

        // create some fake users
        User::factory()->count(2)->create();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(403);

        $this->assertResponseContainKeyValue([
            'message' => 'This action is unauthorized.',
        ]);
    }

    /**
     * @test
     */
    public function testSearchUsersByName(): void
    {
        $user = $this->getTestingUser([
            'username' => 'usersszzz',
        ]);

        $user->assignRole($this->access['roles']);

        // 3 random users
        User::factory()->count(3)->create();

        // send the HTTP request
        $response = $this->endpoint(sprintf('%s?search=username:usersszzz', $this->getEndpoint()))->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseArray = $response->decodeResponseJson();

        self::assertEquals($user->username, $responseArray['data'][0]['username']);

        // assert only single user was returned
        $this->assertCount(1, $responseArray['data']);
    }
}
