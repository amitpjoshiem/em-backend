<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Tasks;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsEnum;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Parents\Tasks\Task;

class CheckClientCanBeSubmittedTask extends Task
{
    public function run(Client $client): bool
    {
        $fields = $client->only(ClientDocumentsEnum::requiredSteps());

        return !\in_array(Client::NOT_COMPLETED_STEP, $fields, true);
    }
}
