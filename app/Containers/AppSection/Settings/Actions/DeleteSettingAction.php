<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Actions;

use App\Containers\AppSection\Settings\Exceptions\SettingNotFoundException;
use App\Containers\AppSection\Settings\Tasks\DeleteSettingTask;
use App\Containers\AppSection\Settings\Tasks\FindSettingByIdTask;
use App\Containers\AppSection\Settings\UI\API\Requests\DeleteSettingRequest;
use App\Ship\Parents\Actions\Action;

class DeleteSettingAction extends Action
{
    public function run(DeleteSettingRequest $request): void
    {
        $setting = app(FindSettingByIdTask::class)->run($request->id);

        if ($setting === null) {
            throw new SettingNotFoundException();
        }

        app(DeleteSettingTask::class)->run($setting);
    }
}
