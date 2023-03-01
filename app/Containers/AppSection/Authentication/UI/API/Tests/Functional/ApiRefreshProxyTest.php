<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\UI\API\Tests\Functional;

use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\Tests\ApiTestCase;

/**
 * Class ApiRefreshProxyTest.
 *
 * @group authentication
 * @group api
 */
class ApiRefreshProxyTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/refresh';

    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    private array $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'email'    => 'testing@mail.com',
            'password' => 'testing_pass',
        ];

        $user = $this->getTestingUser($this->data);
        $this->actingAs($user, 'api');
    }

    public function testRequestingRefreshTokenWithoutPassingARefreshTokenShouldThrowAnException(): void
    {
        $data = [
            'refresh_token' => null,
        ];

        $response = $this->makeCall($data);

        $response->assertStatus(400);

        $message = (new RefreshTokenMissedException())->getMessage();
        $this->assertResponseContainKeyValue(['message' => $message]);
    }

    public function testOnSuccessfulRefreshTokenRequestEnsureValuesAreSetProperly(): void
    {
        $loginResponse = $this->endpoint('post@v1/login')->makeCall($this->data);

        $content = $loginResponse->getContent();

        self::assertNotFalse($content);

        $refreshToken  = json_decode($content, true, 512, JSON_THROW_ON_ERROR)['refresh_token'];
        $data          = [
            'refresh_token' => $refreshToken,
        ];

        // Reset endpoint to default value
        $this->endpoint(null);
        $response = $this->endpoint($this->getEndpoint())->makeCall($data);

        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'token_type' => 'Bearer',
        ]);

        $this->assertResponseContainKeys(['expires_in', 'access_token']);
    }
}
