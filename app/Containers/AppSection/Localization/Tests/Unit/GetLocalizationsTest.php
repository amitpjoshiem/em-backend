<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Tests\Unit;

use App\Containers\AppSection\Localization\Tasks\GetAllLocalizationsTask;
use App\Containers\AppSection\Localization\Tests\TestCase;
use App\Containers\AppSection\Localization\Values\Localization;

/**
 * Class GetLocalizationsTest.
 *
 * @group localization
 * @group unit
 */
class GetLocalizationsTest extends TestCase
{
    public function testIfAllSupportedLanguagesAreReturned(): void
    {
        $localizations = app(GetAllLocalizationsTask::class)->run();

        $configuredLocalizations = config('appSection-localization.supported_languages', []);

        // Assert that they have the same amount of fields
        self::assertEquals(is_countable($configuredLocalizations) ? \count($configuredLocalizations) : 0, $localizations->count());
    }

    public function testIfSpecificLocaleIsReturned(): void
    {
        $localizations = app(GetAllLocalizationsTask::class)->run();

        $unsupportedLocale = new Localization('fr');

        self::assertContainsEquals($unsupportedLocale, $localizations);
    }

    public function testIfSpecificLocaleWithRegionsIsReturned(): void
    {
        $localizations = app(GetAllLocalizationsTask::class)->run();

        $unsupportedLocale = new Localization('en', ['en-GB', 'en-US']);

        self::assertContainsEquals($unsupportedLocale, $localizations);
    }

    public function testIfWrongLocaleIsNotReturned(): void
    {
        $localizations = app(GetAllLocalizationsTask::class)->run();

        $unsupportedLocale = new Localization('xxx');

        self::assertNotContainsEquals($unsupportedLocale, $localizations);
    }
}
