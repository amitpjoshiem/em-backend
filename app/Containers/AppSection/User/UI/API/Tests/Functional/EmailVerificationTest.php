<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\VerifyEmailNotification;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tests\ApiTestCase;
use Illuminate\Support\Arr;

/**
 * Class EmailVerificationTest.
 *
 * @group user
 * @group api
 */
class EmailVerificationTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/email/verify/{id}/{hash}';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testEmailVerification(): void
    {
        $admin = $this->getTestingUser();

        /** @var array params for routes userId + hash */
        $routeParam = [
            'id'   => $admin->getHashedKey(),
            'hash' => sha1($admin->getEmailForVerification()),
        ];

        /** @var array getting params for sign url */
        $param = VerifyEmailNotification::getParamsForVerificationUrl($admin);

        // send the HTTP request
        $response = $this
            ->injectId($routeParam['id'], true)
            ->injectId($routeParam['hash'], true, '{hash}')
            ->makeCall(Arr::only($param, ['expires', 'signature']));

        // assert response status is correct
        $response->assertStatus(202);

        // assert message of success
        $this->assertResponseContainKeyValue([
            'message' => 'Your email was successfully verified.',
        ]);

        $dbUser = app(FindUserByIdTask::class)->run($admin->id);
        self::assertInstanceOf(User::class, $dbUser);
        $this->assertNotEmpty($dbUser->email_verified_at);
    }
}
