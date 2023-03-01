<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\DeleteClientHelpVideoTransporter;
use App\Containers\AppSection\Client\Tasks\FindClientHelpByTypeTask;
use App\Containers\AppSection\Media\Tasks\DeleteAllModelMediaTask;
use App\Ship\Parents\Actions\SubAction;

class DeleteClientHelpVideoAction extends SubAction
{
    public function run(DeleteClientHelpVideoTransporter $data): void
    {
        $clientHelp = app(FindClientHelpByTypeTask::class)->run($data->type);

        app(DeleteAllModelMediaTask::class)->run($clientHelp);
    }
}
