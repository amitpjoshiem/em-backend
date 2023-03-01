<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Actions;

use App\Containers\AppSection\Media\Data\Transporters\CreateMediaByOneFileTransporter;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadModelTransporter;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\Tasks\CreateMediaTask;
use App\Containers\AppSection\Media\Tasks\CreateTemporaryUploadTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Str;

class CreateTemporaryUploadMediaAction extends Action
{
    public function run(CreateTemporaryUploadMediaTransporter $createMediaData): TemporaryUpload
    {
        $tempUploadData = CreateTemporaryUploadModelTransporter::fromTransporter($createMediaData, ['uuid' => Str::uuid()]);

        $model = app(CreateTemporaryUploadTask::class)->run($tempUploadData->toArray());

        if (isset($createMediaData->file)) {
            /** Let's bring to one form so as not to duplicate code*/
            $createMediaData->files[] = $createMediaData->file;
        }

        foreach ($createMediaData->files as $file) {
            $mediaData = CreateMediaByOneFileTransporter::fromTransporter($createMediaData, ['model' => $model, 'file' => $file]);

            app(CreateMediaTask::class)->run($mediaData);
        }

        return $model->refresh();
    }
}
