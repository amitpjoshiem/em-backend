<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit;

use App\Containers\AppSection\Authentication\Tasks\ExtractLoginCustomAttributeTask;
use App\Containers\AppSection\Authentication\Tests\TestCase;
use App\Ship\Parents\Transporters\Transporter;

/**
 * Class ExtractLoginCustomAttributeTest.
 *
 * @group authentication
 * @group unit
 */
class ExtractLoginCustomAttributeTest extends TestCase
{
    public function testGivenValidLoginAttributeThenExtractUsername(): void
    {
        $transporter                = new class () extends Transporter {
            public string $email    = 'test@test.test';

            public string $password = 'so-secret';
        };

        $loginAttr = app(ExtractLoginCustomAttributeTask::class)->run($transporter);

        $this->assertAttributeIsExtracted($loginAttr->toArray(), $transporter->toArray());
    }

    private function assertAttributeIsExtracted(array $result, array $userDetails): void
    {
        self::assertArrayHasKey('username', $result);
        self::assertArrayHasKey('loginAttribute', $result);
        self::assertSame($result['username'], $userDetails['email']);
    }

    public function testWhenNoLoginAttributeIsProvidedShouldUseEmailFieldAsDefaultFallback(): void
    {
        config()->offsetUnset('appSection-authentication.login.attributes');

        $transporter                = new class () extends Transporter {
            public string $email    = 'test@test.test';

            public string $password = 'so-secret';
        };

        $loginAttr = app(ExtractLoginCustomAttributeTask::class)->run($transporter);

        $this->assertAttributeIsExtracted($loginAttr->toArray(), $transporter->toArray());
    }
}
