<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Tests\Functional;

use App\Containers\AppSection\Salesforce\Services\Objects\Api;
use App\Containers\AppSection\Salesforce\Tests\ApiTestCase;
use Illuminate\Support\Facades\Cache;

class GetAuthSettingsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/salesforce/auth/settings';

    /**
     * @test
     */
    public function testGetAuthSettings(): void
    {
        $user = $this->getTestingUser();

        $response = $this->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertFalse($content['auth']);

        $parsedUrl = parse_url($content['link']);

        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        parse_str($parsedUrl['query'], $query);

        $this->assertEquals(config('appSection-salesforce.clientId'), $query['client_id']);
        $this->assertEquals(route('web_salesforce_auth_callback'), $query['redirect_uri']);
        $this->assertEquals($user->getHashedKey(), $query['state']);
        $this->assertTrue(Cache::has(Api::TOKEN_CACHE_KEY));
        $this->assertTrue(Cache::has(Api::INSTANCE_CACHE_KEY));
    }
}
