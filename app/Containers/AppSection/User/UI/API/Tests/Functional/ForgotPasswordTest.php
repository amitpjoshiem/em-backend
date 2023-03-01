<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordTest.
 *
 * @group user
 * @group api
 */
class ForgotPasswordTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/password/forgot';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testForgotPassword(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->makeCall([
            'email'     => $admin->email,
            'reset_url' => 'password-reset',
        ]);

        // assert response status is correct
        $response->assertStatus(200);

        // assert message of success
        $this->assertResponseContainKeyValue([
            'message' => trans(Password::RESET_LINK_SENT),
        ]);
    }

    /**
     * @test
     */
    public function testForgotPasswordIncorrectEmail(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->makeCall([
            'email'     => sprintf('test_%s', $admin->email),
            'reset_url' => 'password-reset',
        ]);

        // assert response status is correct
        $response->assertStatus(200);

        // assert message of error
        $this->assertResponseContainKeyValue([
            'message' => trans(Password::INVALID_USER),
        ]);
    }
}
