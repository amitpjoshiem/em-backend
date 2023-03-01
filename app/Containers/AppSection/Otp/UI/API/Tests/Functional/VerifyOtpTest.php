<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Tests\Functional;

use App\Containers\AppSection\Otp\Mails\OtpMail;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Tasks\GetUserValidOtpTokenTask;
use App\Containers\AppSection\Otp\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Token;

/**
 * Class LoginWithoutOtpTest.
 *
 * @group otp
 * @group api
 */
class VerifyOtpTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/otps/verify';

    // fake some access rights
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function testVerifyOtp(): void
    {
        Mail::fake();

        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;

        Mail::assertQueued(OtpMail::class, function (OtpMail $mail) use (&$code): bool {
            $mail->build();
            $code = $mail->viewData['code'];

            return true;
        });

        $verifyData = [
            'code' => $code,
        ];

        $response = $this->endpoint($this->endpoint)->makeCall($verifyData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);

        /** @var Otp $otp */
        $otp = app(GetUserValidOtpTokenTask::class)->run($user->getKey());

        $response->assertCookie(config('appSection-otp.otp_cookie_name'), $otp->external_token, false);

        /** @var Token $token */
        $token = $user->tokens->first();

        $this->assertDatabaseHas('otps', [
            $user->getForeignKey()  => $user->getKey(),
            'oauth_access_token_id' => $token->getKey(),
        ]);
    }

    public function testGetAccessWithOtp(): void
    {
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;
        $this->verifyOtp($user, $token);

        $response = $this->endpoint('get@v1/users/profile')
            ->makeCall(headers: [
                'Authorization' => 'Bearer ' . $token,
            ]);

        $response->assertStatus(200);
    }
}
