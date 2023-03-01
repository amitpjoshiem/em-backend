<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Tests\Functional;

use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Services\EmailOtpService;
use App\Containers\AppSection\Otp\Services\GoogleOtpService;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\Otp\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Core\Exceptions\UndefinedMethodException;
use OTPHP\TOTP;

/**
 * Class LoginWithoutOtpTest.
 *
 * @group otp
 * @group api
 */
class ChangeOtpTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/otps/change';

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
    public function testChangeToGoogleAndEmail(): void
    {
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;
        $this->verifyOtp($user, $token);

        /** @var OtpSecurity $otpSecret */
        $otpSecret = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        $code = TOTP::create($otpSecret->secret)->at((int)now()->timestamp);

        $response = $this->endpoint($this->endpoint)->makeCall([
            'service'   => 'google',
            'code'      => $code,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);

        $className = quotemeta(GoogleOtpService::class);

        $this->assertDatabaseHas('otp_securities', [
            'user_id'      => $user->getKey(),
            'service_type' => sprintf('"%s"', $className),
        ]);

        $response = $this->endpoint($this->endpoint)->makeCall([
            'service'   => 'email',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);

        $className = quotemeta(EmailOtpService::class);

        $this->assertDatabaseHas('otp_securities', [
            'user_id'      => $user->getKey(),
            'service_type' => sprintf('"%s"', $className),
        ]);
    }
}
