<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Actions;

use App\Containers\AppSection\Media\Data\Transporters\DeleteMediaTransporter;
use App\Containers\AppSection\Media\Tasks\DeleteMediaTask;
use App\Ship\Parents\Actions\Action;

class DeleteMediaAction extends Action
{
    public function run(DeleteMediaTransporter $mediaData): bool
    {
        return app(DeleteMediaTask::class)->run($mediaData->id);
    }
}
