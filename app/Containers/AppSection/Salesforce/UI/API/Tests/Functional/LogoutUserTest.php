<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional;

use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;

class LogoutUserTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/salesforce/auth/logout';

    /**
     * @test
     */
    public function testLogout(): void
    {
        $user = $this->getTestingUser();

        SalesforceUser::factory()->create([
            'user_id'   => $user->getKey(),
        ]);

        $response = $this->makeCall();

        $response->assertSuccessful();

        $this->assertDatabaseMissing('salesforce_users', [
            'user_id'   => $user->getKey(),
        ]);
    }
}
