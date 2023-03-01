<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Actions;

use App\Containers\AppSection\Media\Data\Transporters\GetAllMediaByTemporaryUploadUuidsTransporter;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Tasks\GetAllMediaByTemporaryUploadUuidsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class GetAllMediaByTemporaryUploadUuidsAction extends Action
{
    /**
     * @return Collection|Media[]
     */
    public function run(GetAllMediaByTemporaryUploadUuidsTransporter $uuidsTransporter): Collection | array
    {
        return app(GetAllMediaByTemporaryUploadUuidsTask::class)->run($uuidsTransporter->uuids, $uuidsTransporter->collection);
    }
}
