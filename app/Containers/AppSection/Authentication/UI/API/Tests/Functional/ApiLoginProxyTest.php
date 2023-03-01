<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\UI\API\Tests\Functional;

use App\Containers\AppSection\Authentication\Tests\ApiTestCase;
use Illuminate\Support\Facades\Config;

/**
 * Class ApiLoginProxyTest.
 *
 * @group authentication
 * @group api
 */
class ApiLoginProxyTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/login';

    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function testClientApiProxyLogin(): void
    {
        // Create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'email'    => 'testing@mail.com',
            'password' => 'testingpass',
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $response->assertCookie('refreshToken');

        $this->assertResponseContainKeyValue([
            'token_type' => 'Bearer',
        ]);

        $this->assertResponseContainKeys(['expires_in', 'access_token']);
    }

    public function testClientApiProxyUnconfirmedLogin(): void
    {
        // Create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'email'             => 'testing2@mail.com',
            'password'          => 'testingpass',
            'email_verified_at' => null,
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $response = $this->makeCall($data);

        if (config('appSection-authentication.require_email_confirmation')) {
            $response->assertStatus(409);
        } else {
            $response->assertStatus(200);
        }
    }

    public function testLoginWithNameAttribute(): void
    {
        // Create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'email'    => 'testing@mail.com',
            'password' => 'testingpass',
            'username' => 'username',
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        // Specifically allow to login with "username" attribute
        $this->setLoginAttributes([
            'email'     => [],
            'username'  => [],
        ]);

        $request = [
            'password' => 'testingpass',
            'username' => 'username',
        ];

        $response = $this->makeCall($request);

        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'token_type' => 'Bearer',
        ]);

        self::assertEquals('refreshToken', collect($response->headers->getCookies())->first()->getName());

        $this->assertResponseContainKeys(['expires_in', 'access_token', 'refresh_token']);
    }

    public function testGivenOnlyOneLoginAttributeIsSetThenItShouldBeRequired(): void
    {
        $this->setLoginAttributes([
            'email' => [],
        ]);

        $data = [
            'password' => 'so-secret',
        ];

        $this->makeCall($data);

        $this->assertValidationErrorContain([
            'email' => 'The email field is required.',
        ]);
    }

    public function testGivenMultipleLoginAttributeIsSetThenAtLeastOneShouldBeRequired(): void
    {
        $this->setLoginAttributes([
            'email'    => [],
            'username' => [],
        ]);

        $data = [
            'password' => 'so-secret',
        ];

        $this->makeCall($data);

        $this->assertValidationErrorContain([
            'email'    => 'The email field is required when none of username are present.',
            'username' => 'The username field is required when none of email are present.',
        ]);
    }

    private function setLoginAttributes(array $attributes): void
    {
        Config::set('appSection-authentication.login.attributes', $attributes);
    }
}
