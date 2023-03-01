<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Tests\Functional;

use App\Containers\AppSection\Otp\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

/**
 * Class LoginWithoutOtpTest.
 *
 * @group otp
 * @group api
 */
class RefreshOtpTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/refresh';

    // fake some access rights
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function testRefreshOtp(): void
    {
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;
        $this->verifyOtp($user, $token);
        $refreshToken = $this->refreshToken;

        $response = $this->endpoint($this->endpoint)->makeCall([
            'refresh_token' => $refreshToken,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('otps', [
            $user->getForeignKey()  => $user->getKey(),
            'oauth_access_token_id' => $user->tokens->first()->getKey(),
            'revoked'               => false,
        ]);
    }
}
