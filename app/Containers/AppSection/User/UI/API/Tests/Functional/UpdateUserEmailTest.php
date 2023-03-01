<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class UpdateUserEmailTest.
 *
 * @group user
 * @group api
 */
class UpdateUserEmailTest extends ApiTestCase
{
    protected string $endpoint = 'put@v1/email';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testUpdateUserEmail(): void
    {
        $this->getTestingUser();

        $data = [
            'email' => $this->faker->unique()->safeEmail,
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(202);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue(['message' => 'Email verification link sent on your email.']);

        // assert data was updated in the database
        $this->assertDatabaseHas('users', ['email' => $data['email'], 'email_verified_at' => null]);
    }
}
