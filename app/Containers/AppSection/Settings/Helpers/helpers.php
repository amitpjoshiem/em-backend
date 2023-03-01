<?php

declare(strict_types=1);

use App\Containers\AppSection\Settings\Models\Setting;
use App\Containers\AppSection\Settings\Tasks\FindSettingByKeyTask;

if (!function_exists('getSetting')) {

    /**
     * Get system configuration.
     */
    function getSetting(string $settingKey): string
    {
        /** @var Setting $setting */
        $setting = app(FindSettingByKeyTask::class)->run($settingKey);

        return $setting->value;
    }
}

if (!function_exists('getSettingExample')) {
    function getSettingExample(): string
    {
        return getSetting('get_setting_example');
    }
}
