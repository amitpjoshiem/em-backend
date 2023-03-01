<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Actions;

use App\Containers\AppSection\Settings\Models\Setting;
use App\Containers\AppSection\Settings\Tasks\CreateSettingTask;
use App\Containers\AppSection\Settings\UI\API\Requests\CreateSettingRequest;
use App\Ship\Parents\Actions\Action;

class CreateSettingAction extends Action
{
    public function run(CreateSettingRequest $settingRequest): Setting
    {
        $input = $settingRequest->sanitizeInput([
            'key',
            'value',
        ]);

        return app(CreateSettingTask::class)->run($input);
    }
}
