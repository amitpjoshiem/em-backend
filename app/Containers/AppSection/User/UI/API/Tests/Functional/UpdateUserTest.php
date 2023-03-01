<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Data\Enums\UserPermissionEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class UpdateUserTest.
 *
 * @group user
 * @group api
 */
class UpdateUserTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/users/{id}';

    protected array $access = [
        'roles'       => '',
        'permissions' => UserPermissionEnum::UPDATE,
    ];

    /**
     * @test
     */
    public function testUpdateExistingUser(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $data = [
            'username' => 'Updated username',
        ];

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'object'   => 'User',
            'email'    => $user->email,
            'username' => $data['username'],
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('users', ['username' => $data['username']]);
    }

    /**
     * @test
     */
    public function testUpdateNonExistingUser(): void
    {
        $data = [
            'username' => 'Updated Username',
        ];

        $fakeUserId = 7777;

        // send the HTTP request
        $response = $this->injectId($fakeUserId)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateExistingUserWithoutData(): void
    {
        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateExistingUserWithEmptyValues(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $data = [
            'username'   => '1',
            'first_name' => '1',
        ];

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertValidationErrorContain([
            // messages should be updated after modifying the validation rules, to pass this test
            'username'   => 'The username must be at least 2 characters.',
            'first_name' => 'The first name must be at least 2 characters.',
        ]);
    }
}
