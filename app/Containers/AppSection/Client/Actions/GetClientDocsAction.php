<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\GetClientDocsTransporter;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientDocsTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GetClientDocsAction extends Action
{
    public function run(GetClientDocsTransporter $uploadData): OutputClientDocsTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        return new OutputClientDocsTransporter([
            'status'    => $user->client->getAttribute($uploadData->collection),
            'documents' => $user->client->getCollectionDocs($uploadData->collection),
        ]);
    }
}
