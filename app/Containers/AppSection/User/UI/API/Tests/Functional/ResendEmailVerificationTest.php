<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Tests\Functional;

use App\Containers\AppSection\User\Tests\ApiTestCase;

/**
 * Class ResendEmailVerificationTest.
 *
 * @group user
 * @group api
 */
class ResendEmailVerificationTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/email/resend';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testResendEmailVerification(): void
    {
        $this->getTestingUser();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertNoContent();
    }
}
