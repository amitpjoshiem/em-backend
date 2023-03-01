<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Transporters\HelpClientVideoTransporter;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientHelpTransporter;
use App\Containers\AppSection\Client\Models\ClientHelp;
use App\Containers\AppSection\Client\Tasks\FindClientHelpByTypeTask;
use App\Ship\Parents\Actions\Action;

class HelpClientVideoAction extends Action
{
    public function run(HelpClientVideoTransporter $data): OutputClientHelpTransporter
    {
        /** @var ClientHelp | null $help */
        $help = app(FindClientHelpByTypeTask::class)->run($data->page);

        return new OutputClientHelpTransporter([
            'type'  => $data->page,
            'media' => $help?->media->first(),
            'text'  => $help?->text,
        ]);
    }
}
