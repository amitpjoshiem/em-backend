<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\UI\API\Tests\Functional;

use App\Containers\AppSection\Localization\Tests\ApiTestCase;

/**
 * Class CheckLocalizationMiddlewareTest.
 *
 * @group localization
 * @group api
 */
class CheckLocalizationMiddlewareTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/localizations';

    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function testIfMiddlewareSetsDefaultAppLanguage(): void
    {
        $data            = [];
        $requestHeaders  = [];
        $defaultLanguage = config('app.locale');

        $response = $this->makeCall($data, $requestHeaders);

        $response
            ->assertStatus(200)
            ->assertHeader('content-language', $defaultLanguage);
    }

    public function testIfMiddlewareSetsCustomLanguage(): void
    {
        $language = 'fr';

        $data           = [];
        $requestHeaders = [
            'accept-language' => $language,
        ];

        $response = $this->makeCall($data, $requestHeaders);

        $response
            ->assertStatus(200)
            ->assertHeader('content-language', $language);
    }

    public function testIfMiddlewareThrowsErrorOnWrongLanguage(): void
    {
        $language = 'xxx';

        $data           = [];
        $requestHeaders = [
            'accept-language' => $language,
        ];

        $response = $this->makeCall($data, $requestHeaders);

        if (config('appSection-localization.force-valid-locale', true)) {
            $response->assertStatus(412);
        } else {
            $response->assertStatus(200);
        }
    }
}
