<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\WEB\Tests\Functional;

use App\Containers\AppSection\Salesforce\Tests\WebTestCase;

class AuthRedirectTest extends WebTestCase
{
    protected string $endpoint = 'get@salesforce/auth/callback';

    /**
     * @test
     */
    public function testAuthRedirect(): void
    {
        $user = $this->getTestingUser();

        $response = $this->makeCall([
            'code'  => $this->faker->randomNumber(),
            'state' => $user->getHashedKey(),
        ]);

        $response->assertRedirect(config('app.frontend_url') . config('appSection-salesforce.salesforce_front_path'));
        $this->assertDatabaseHas('salesforce_users', [
            'user_id'           => $user->getKey(),
            'salesforce_id'     => $this->fakeUserId,
        ]);
    }
}
