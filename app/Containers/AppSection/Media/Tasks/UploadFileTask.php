<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Actions\CreateTemporaryUploadMediaAction;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadFileTask extends Task
{
    public function run(string $filePath, string $fileName, HasInteractsWithMedia $model, string $collection): Media
    {
        $file = new UploadedFile($filePath, $fileName);
        $data = new CreateTemporaryUploadMediaTransporter([
            'file'       => $file,
            'collection' => $collection,
        ]);
        /** @var TemporaryUpload $temporaryUpload */
        $temporaryUpload = app(CreateTemporaryUploadMediaAction::class)->run($data);

        /** @psalm-suppress UndefinedInterfaceMethod */
        return app(AttachMediaFromUuidsToModelSubAction::class)->run($model, [$temporaryUpload->uuid], $collection)
            ->getMedia($collection)
            ->last();
    }
}
