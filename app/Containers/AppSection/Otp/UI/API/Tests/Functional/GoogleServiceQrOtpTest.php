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
class GoogleServiceQrOtpTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/otps/google/qr';

    // fake some access rights
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function testGetGoogleQr(): void
    {
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;
        $this->verifyOtp($user, $token);

        $response = $this->endpoint($this->endpoint)
            ->makeCall(headers: [
                'Authorization' => 'Bearer ' . $token,
            ]);

        $response->assertStatus(200);

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertDatabaseHas('otp_securities', [
            $user->getForeignKey()  => $user->getKey(),
            'secret'                => $content['data']['code'],
        ]);

        $qrUrl = urldecode($content['data']['url']);
        /** @var string $appName */
        $appName = config('app.name');

        $this->assertTrue((bool)preg_match(
            sprintf('/data=otpauth:\/\/totp\/%s:%s\?secret=%s&issuer=%s/', $appName, $user->email, $content['data']['code'], $appName),
            $qrUrl
        ));
    }
}
