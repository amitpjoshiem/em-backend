<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class GetAuthenticatedUserTest.
 *
 * @group user
 * @group api
 */
class GetAuthenticatedUserTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/profile';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testUserProfile(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // assert main fields from request
        $this->assertResponseContainKeyValue([
            'object'    => 'User',
            'id'        => $admin->getHashedKey(),
            'username'  => $admin->username,
            'email'     => $admin->email,
        ]);
    }
}
