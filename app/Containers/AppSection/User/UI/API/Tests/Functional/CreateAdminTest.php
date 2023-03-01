<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class CreateAdminTest.
 *
 * @group user
 * @group api
 */
class CreateAdminTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/admins';

    protected array $access = [
        'permissions' => UserPermissionEnum::CREATE_ADMINS,
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testCreateAdmin(): void
    {
        $data = [
            'email'                 => $this->faker->unique()->email,
            'username'              => $this->faker->unique()->userName,
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'email'    => $data['email'],
            'username' => $data['username'],
        ]);

        // assert response contain the token
        $this->assertResponseContainKeys(['id']);

        // assert the data is stored in the database
        $this->assertDatabaseHas('users', ['email' => $data['email'], 'is_client' => false]);
    }
}
