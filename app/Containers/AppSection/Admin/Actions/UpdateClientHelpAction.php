<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\UpdateClientHelpTransporter;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientHelpTransporter;
use App\Containers\AppSection\Client\Models\ClientHelp;
use App\Containers\AppSection\Client\Tasks\SaveClientHelpByTypeTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Media\Tasks\DeleteAllModelMediaTask;
use App\Ship\Parents\Actions\SubAction;

class UpdateClientHelpAction extends SubAction
{
    public function run(UpdateClientHelpTransporter $data): OutputClientHelpTransporter
    {
        $saveData = [];

        if (isset($data->text)) {
            $saveData['text'] = $data->text;
        }

        $clientHelp = app(SaveClientHelpByTypeTask::class)->run($data->type, $saveData);

        if (isset($data->uuids)) {
            app(DeleteAllModelMediaTask::class)->run($clientHelp);
            /** @var ClientHelp $clientHelp */
            $clientHelp = app(AttachMediaFromUuidsToModelSubAction::class)->run($clientHelp, $data->uuids, MediaCollectionEnum::CLIENT_HELP);

            /** @var Media | null $media */
            $media = $clientHelp->getMedia(MediaCollectionEnum::CLIENT_HELP)->first();
        }

        return new OutputClientHelpTransporter([
            'text'  => $clientHelp->text,
            'media' => $media ?? $clientHelp->media->first(),
            'type'  => $data->type,
        ]);
    }
}
