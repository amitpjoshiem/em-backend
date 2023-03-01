<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\SubActions;

use App\Containers\AppSection\Media\Actions\CreateTemporaryUploadMediaAction;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Http\UploadedFile;

class AttachDocumentSubAction extends SubAction
{
    public function __construct()
    {
    }

    public function run(UploadedFile $file, string $collection, HasInteractsWithMedia $model): HasInteractsWithMedia
    {
        $data = new CreateTemporaryUploadMediaTransporter([
            'file'       => $file,
            'collection' => $collection,
        ]);
        /** @var TemporaryUpload $temporaryUpload */
        $temporaryUpload = app(CreateTemporaryUploadMediaAction::class)->run($data);

        return app(AttachMediaFromUuidsToModelSubAction::class)->run($model, [$temporaryUpload->uuid], $collection);
    }
}
