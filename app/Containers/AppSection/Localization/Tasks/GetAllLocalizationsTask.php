<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Tasks;

use App\Containers\AppSection\Localization\Values\Localization;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetAllLocalizationsTask extends Task
{
    public function run(): Collection
    {
        $supportedLocalizations = (array)config('appSection-localization.supported_languages');

        $localizations = new Collection();

        foreach ($supportedLocalizations as $key => $value) {
            // It is a simple key
            if (!\is_array($value)) {
                $localizations->push(new Localization($value));
            } else { // It is a composite key
                $localizations->push(new Localization($key, $value));
            }
        }

        return $localizations;
    }
}
