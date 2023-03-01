<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsTypesEnum;
use App\Ship\Parents\Actions\Action;

class GetClientDocsTypes extends Action
{
    public function run(): array
    {
        return ClientDocumentsTypesEnum::values();
    }
}
