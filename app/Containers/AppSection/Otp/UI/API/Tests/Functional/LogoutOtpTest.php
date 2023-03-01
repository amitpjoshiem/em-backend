<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Tests\Functional;

use App\Containers\AppSection\Otp\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Core\Exceptions\UndefinedMethodException;

/**
 * Class LoginWithoutOtpTest.
 *
 * @group otp
 * @group api
 */
class LogoutOtpTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/logout';

    // fake some access rights
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * @test
     *
     * @throws UndefinedMethodException
     */
    public function testLogoutOtp(): void
    {
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;
        $this->verifyOtp($user, $token);

        $response = $this->endpoint($this->endpoint)->makeCall(headers: [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(202);

        $response->assertCookie(config('appSection-otp.otp_cookie_name'));

        $this->assertDatabaseMissing('otps', [
            $user->getForeignKey()  => $user->getKey(),
            'revoked'               => false,
        ]);
    }
}
