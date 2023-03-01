<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientDocsTransporter;
use App\Containers\AppSection\Client\Data\Transporters\UploadClientDocsTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Client\Tasks\SaveClientDocsAdditionalInfoTask;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Media\Tasks\GetAllTemporaryUploadByUuidsTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class UploadClientDocsAction extends Action
{
    public function run(UploadClientDocsTransporter $uploadData): OutputClientDocsTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        /** @var TemporaryUpload $temporaryUpload */
        $temporaryUpload = app(GetAllTemporaryUploadByUuidsTask::class)->run($uploadData->uuids ?? [])->first();

        app(SaveClientDocsAdditionalInfoTask::class)->run(
            $user->client->getKey(),
            $temporaryUpload->media->first()->getKey(),
            [
                'name'        => $uploadData->name,
                'description' => $uploadData->description ?? null,
                'type'        => $uploadData->type ?? null,
                'is_spouse'   => $uploadData->is_spouse,
            ],
        );

        /** @var Client $client */
        $client = app(AttachMediaFromUuidsToModelSubAction::class)->run($user->client, $uploadData->uuids, $uploadData->collection);

        return new OutputClientDocsTransporter([
            'status'    => $client->getAttribute($uploadData->collection),
            'documents' => $client->getCollectionDocs($uploadData->collection),
        ]);
    }
}
