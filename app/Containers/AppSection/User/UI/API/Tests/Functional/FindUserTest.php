<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class FindUsersTest.
 *
 * @group user
 * @group api
 */
class FindUserTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/{id}';

    protected array $access = [
        'roles'       => '',
        'permissions' => UserPermissionEnum::SEARCH,
    ];

    /**
     * @test
     */
    public function testFindUser(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($admin->username, $responseContent->data->username);
    }

    /**
     * @test
     */
    public function testFindFilteredUserResponse(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->endpoint($this->getEndpoint() . '?filter=email;username')->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($admin->username, $responseContent->data->username);
        self::assertEquals($admin->email, $responseContent->data->email);

        // convert response to array
        $responseArray = $response->json();

        $this->assertNotContains('id', $responseArray);
    }

    /**
     * @test
     */
    public function testFindUserWithRelation(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->endpoint($this->getEndpoint() . '?include=roles')->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        self::assertEquals($admin->email, $responseContent->data->email);

        $this->assertNotNull($responseContent->data->roles);
    }
}
