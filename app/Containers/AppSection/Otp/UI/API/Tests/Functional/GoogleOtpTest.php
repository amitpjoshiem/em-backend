<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Tests\Functional;

use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\Otp\Tasks\GetUserValidOtpTokenTask;
use App\Containers\AppSection\Otp\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Core\Exceptions\UndefinedMethodException;
use Laravel\Passport\Token;
use OTPHP\TOTP;

/**
 * Class LoginWithoutOtpTest.
 *
 * @group otp
 * @group api
 */
class GoogleOtpTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/otps/verify';

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
    public function testLoginWithGoogleOtp(): void
    {
        $this->changeOtpToGoogle();
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;

        /** @var OtpSecurity $otpSecret */
        $otpSecret = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        $code = TOTP::create($otpSecret->secret)->at((int)now()->timestamp);

        $response = $this->endpoint($this->endpoint)->makeCall([
            'code'  => $code,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);

        /** @var Otp $otp */
        $otp = app(GetUserValidOtpTokenTask::class)->run($user->getKey());

        $response->assertCookie(config('appSection-otp.otp_cookie_name'), $otp->external_token, false);

        /** @var Token $token */
        $token = $user->tokens->filter(fn (Token $token): bool => $token->getAttribute('revoked') === false)->first();

        $this->assertDatabaseHas('otps', [
            $user->getForeignKey()  => $user->getKey(),
            'oauth_access_token_id' => $token->getKey(),
        ]);
    }
}
