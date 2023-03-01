<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\UI\API\Controllers;

use App\Containers\AppSection\Settings\Actions\CreateSettingAction;
use App\Containers\AppSection\Settings\Actions\DeleteSettingAction;
use App\Containers\AppSection\Settings\Actions\GetAllSettingsAction;
use App\Containers\AppSection\Settings\Actions\UpdateSettingAction;
use App\Containers\AppSection\Settings\UI\API\Requests\CreateSettingRequest;
use App\Containers\AppSection\Settings\UI\API\Requests\DeleteSettingRequest;
use App\Containers\AppSection\Settings\UI\API\Requests\GetAllSettingsRequest;
use App\Containers\AppSection\Settings\UI\API\Requests\UpdateSettingRequest;
use App\Containers\AppSection\Settings\UI\API\Transformers\SettingTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function getAllSettings(GetAllSettingsRequest $request): array
    {
        $settings = app(GetAllSettingsAction::class)->run();

        return $this->transform($settings, SettingTransformer::class);
    }

    public function createSetting(CreateSettingRequest $request): array
    {
        $setting = app(CreateSettingAction::class)->run($request);

        return $this->transform($setting, SettingTransformer::class);
    }

    public function updateSetting(UpdateSettingRequest $request): array
    {
        $setting = app(UpdateSettingAction::class)->run($request);

        return $this->transform($setting, SettingTransformer::class);
    }

    public function deleteSetting(DeleteSettingRequest $request): JsonResponse
    {
        app(DeleteSettingAction::class)->run($request);

        return $this->noContent();
    }
}
