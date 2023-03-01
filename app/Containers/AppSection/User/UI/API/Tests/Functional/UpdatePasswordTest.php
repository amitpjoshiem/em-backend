<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Support\Facades\Hash;

/**
 * Class UpdatePasswordTest.
 *
 * @group user
 * @group api
 */
class UpdatePasswordTest extends ApiTestCase
{
    protected string $endpoint = 'put@v1/password';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testUpdatePassword(): void
    {
        // Generate passwords
        $password    = $this->faker->password();
        $newPassword = $this->faker->password();

        // Create test user with provided password
        $admin = $this->getTestingUser([
            'password' => $password,
        ]);

        // Send the HTTP request
        $response = $this->makeCall([
            'current_password'      => $password,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Assert response status is correct
        $response->assertStatus(202);

        // Assert message of success
        $this->assertResponseContainKeyValue([
            'message' => 'Password successfully changed.',
        ]);

        // Assert updated password from db
        $dbUser = app(FindUserByIdTask::class)->run($admin->id);
        self::assertInstanceOf(User::class, $dbUser);
        self::assertTrue(Hash::check($newPassword, $dbUser->password));
        $this->assertFalse(Hash::check($password, $dbUser->password));
    }

    public function testUpdatePasswordIncorrect(): void
    {
        // Generate passwords
        $password    = $this->faker->password();
        $newPassword = $this->faker->password();

        // Create test user with provided password
        $admin = $this->getTestingUser([
            'password' => $password,
        ]);

        // Send the HTTP request
        $response = $this->makeCall([
            'current_password'      => sprintf('.%s', $password),
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Assert response status is correct
        $response->assertStatus(409);

        // Assert message of success
        $this->assertResponseContainKeyValue([
            'message' => 'The provided password does not match your current password.',
        ]);

        // Assert updated password from db
        $dbUser = app(FindUserByIdTask::class)->run($admin->id);
        self::assertInstanceOf(User::class, $dbUser);
        $this->assertFalse(Hash::check($newPassword, $dbUser->password));
        self::assertTrue(Hash::check($password, $dbUser->password));
    }
}
