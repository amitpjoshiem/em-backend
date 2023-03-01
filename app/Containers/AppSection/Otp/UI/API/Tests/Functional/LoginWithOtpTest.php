<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Tests\Functional;

use App\Containers\AppSection\Otp\Mails\OtpMail;
use App\Containers\AppSection\Otp\Services\EmailOtpService;
use App\Containers\AppSection\Otp\Services\OtpService;
use App\Containers\AppSection\Otp\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Cache;
use Illuminate\Support\Facades\Mail;

/**
 * Class LoginWithoutOtpTest.
 *
 * @group otp
 * @group api
 */
class LoginWithOtpTest extends ApiTestCase
{
    // the endpoint to be called within this test (e.g., get@v1/users)
    protected string $endpoint = 'post@v1/login';

    // fake some access rights
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testCreateOtpSecret(): void
    {
        $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;

        $className = quotemeta(EmailOtpService::class);

        $this->assertDatabaseHas('otp_securities', [
            'user_id'      => $user->getKey(),
            'service_type' => sprintf('"%s"', $className),
        ]);
    }

    public function testSendEmailWithOtp(): void
    {
        Mail::fake();

        $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;

        Mail::assertQueued(OtpMail::class, function (OtpMail $mail) use ($user): bool {
            $mail->build();
            $this->assertArrayHasKey('code', $mail->viewData);
            $token = $user->tokens->first();
            $this->assertTrue(Cache::has(OtpService::getCacheKey($user->getKey(), $token->getKey())));
            $code = Cache::get(OtpService::getCacheKey($user->getKey(), $token->getKey()));
            $this->assertEquals($code, $mail->viewData['code']);

            return $mail->hasTo($user->email);
        });
    }

    public function testGetAccessWithoutOtp(): void
    {
        $token = $this->loginUser();

        $response = $this->endpoint('get@v1/users/profile')
            ->makeCall(headers: [
                'Authorization' => 'Bearer ' . $token,
            ]);

        $response->assertStatus(401);

        $this->assertResponseContainKeyValue([
            'message' => 'An Exception occurred when trying to authenticate the User.',
        ]);
    }
}
