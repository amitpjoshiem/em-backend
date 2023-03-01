<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Ship\Parents\Tasks\Task;

class FindRowInDropdownOptionTask extends Task
{
    public function run(string $rowName): ?string
    {
        /** @var array $allDropdownOptions */
        $allDropdownOptions = config('appSection-assetsIncome.schema.dropdown_options');

        foreach ($allDropdownOptions as $dropdownName => $dropdownOptions) {
            foreach ($dropdownOptions as $key => $dropdownOption) {
                if (str_contains($rowName, (string)$key)) {
                    return $dropdownName;
                }
            }
        }

        return null;
    }
}
