<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Actions;

use App\Containers\AppSection\Localization\Tasks\GetAllLocalizationsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllLocalizationsAction extends Action
{
    public function run(): Collection
    {
        return app(GetAllLocalizationsTask::class)->run();
    }
}
