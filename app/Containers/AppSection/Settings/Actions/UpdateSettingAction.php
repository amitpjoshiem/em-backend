<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Actions;

use App\Containers\AppSection\Settings\Models\Setting;
use App\Containers\AppSection\Settings\Tasks\UpdateSettingTask;
use App\Containers\AppSection\Settings\UI\API\Requests\UpdateSettingRequest;
use App\Ship\Parents\Actions\Action;

class UpdateSettingAction extends Action
{
    public function run(UpdateSettingRequest $request): Setting
    {
        $sanitizedData = $request->sanitizeInput([
            'key',
            'value',
        ]);

        return app(UpdateSettingTask::class)->run($request->id, $sanitizedData);
    }
}
