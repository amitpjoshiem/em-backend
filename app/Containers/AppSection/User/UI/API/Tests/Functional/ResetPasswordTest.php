<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Class ResetPasswordTest.
 *
 * @group user
 * @group api
 */
class ResetPasswordTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/password/reset';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testResetPassword(): void
    {
        /** @var User $admin */
        $admin = $this->getTestingUser();

        /** @var PasswordBroker $broker */
        $broker = Password::broker();
        $token  = $broker->createToken($admin);

        // generate new password
        $password = $this->faker->password();

        // send the HTTP request
        $response = $this->makeCall([
            'email'                 => $admin->email,
            'token'                 => $token,
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        // assert response status is no content
        $response->assertNoContent();

        // Assert updated password from db
        $dbUser = app(FindUserByIdTask::class)->run($admin->id);
        self::assertInstanceOf(User::class, $dbUser);
        self::assertTrue(Hash::check($password, $dbUser->password));
    }
}
