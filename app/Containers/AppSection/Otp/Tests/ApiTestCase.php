<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tests;

use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Services\OtpService;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use Cache;
use Illuminate\Support\Facades\Hash;
use OTPHP\TOTP;

/**
 * Class ApiTestCase.
 *
 * This is the container API TestCase class. Use this class to add your container specific API related helper functions.
 */
class ApiTestCase extends TestCase
{
    private string $loginEndpoint = 'post@v1/login';

    private string $verifyEndpoint = 'post@v1/otps/verify';

    private string $changeEndpoint = 'post@v1/otps/change';

    private string $logoutEndpoint = 'delete@v1/logout';

    protected string $refreshToken;

    protected function runTest(): void
    {
        if (!config('auth.otp')) {
            $this->assertTrue(true);

            return;
        }

        parent::runTest();
    }

    public function verifyOtp(User $user, string $accessToken): void
    {
        $token = $user->tokens->first();

        $code = Cache::get(OtpService::getCacheKey($user->getKey(), $token->getKey()));

        $response = $this->endpoint($this->verifyEndpoint)->makeCall([
            'code'  => $code,
        ], [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        $response->assertStatus(204);
    }

    public function loginUser(): string
    {
        $password = 'testpass';

        $data = [
            'email'       => 'test@test.com',
            'password'    => Hash::make($password),
        ];

        $user = app(FindUserByEmailTask::class)->run($data['email']);

        if ($user === null) {
            /** @var User $user */
            $user = User::factory()->create($data);
        }

        $this->testingUser = $user;

        $response = $this->endpoint($this->loginEndpoint)->makeCall([
            'email'     => $data['email'],
            'password'  => $password,
        ]);

        $response->assertStatus(200);

        $this->assertContains($response->headers->get('x-otp-type'), ['email', 'google']);
        $response->assertHeader('access-control-expose-headers', 'X-Otp-Type');

        $content = json_decode($response->content(), true, 512, JSON_THROW_ON_ERROR);

        $this->refreshToken = $content['refresh_token'];

        return $content['access_token'];
    }

    public function changeOtpToGoogle(): void
    {
        $token = $this->loginUser();
        /** @var User $user */
        $user = $this->testingUser;
        $this->verifyOtp($user, $token);

        /** @var OtpSecurity $otpSecret */
        $otpSecret = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        $code = TOTP::create($otpSecret->secret)->at((int)now()->timestamp);

        $response = $this->endpoint($this->changeEndpoint)->makeCall([
            'service'   => 'google',
            'code'      => $code,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);

        $this->logoutUser($user, $token);
    }

    public function logoutUser(User $user, string $token): void
    {
        $response = $this->endpoint($this->logoutEndpoint)->makeCall(headers: [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(202);

        $this->assertDatabaseHas('oauth_access_tokens', [
            $user->getForeignKey()  => $user->getKey(),
            'revoked'               => true,
        ]);
    }
}
