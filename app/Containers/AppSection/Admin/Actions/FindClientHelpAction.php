<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\FindClientHelpTransporter;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientHelpTransporter;
use App\Containers\AppSection\Client\Models\ClientHelp;
use App\Containers\AppSection\Client\Tasks\FindClientHelpByTypeTask;
use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Actions\SubAction;

class FindClientHelpAction extends SubAction
{
    public function run(FindClientHelpTransporter $data): OutputClientHelpTransporter
    {
        /** @var ClientHelp | null $clientHelp */
        $clientHelp = app(FindClientHelpByTypeTask::class)->withRelations(['media'])->run($data->type);

        /** @var Media | null $media */
        $media = $clientHelp?->media->first();

        return new OutputClientHelpTransporter([
            'text'  => $clientHelp?->text,
            'media' => $media,
            'type'  => $data->type,
        ]);
    }
}
