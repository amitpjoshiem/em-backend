<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\UI\API\Controllers;

use App\Containers\AppSection\Localization\Actions\GetAllLocalizationsAction;
use App\Containers\AppSection\Localization\UI\API\Requests\GetAllLocalizationsRequest;
use App\Containers\AppSection\Localization\UI\API\Transformers\LocalizationTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function getAllLocalizations(GetAllLocalizationsRequest $request): array
    {
        $localizations = app(GetAllLocalizationsAction::class)->run();

        return $this->transform($localizations, LocalizationTransformer::class);
    }
}
