<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\SubActions;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Events\Events\AttachMediaFromTemporaryUploadEvent;
use App\Containers\AppSection\Media\Events\Events\AttachMediaToModelEvent;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\Tasks\DeleteTemporaryUploadByModelTask;
use App\Containers\AppSection\Media\Tasks\GetAllMediaByModelTask;
use App\Containers\AppSection\Media\Tasks\GetAllTemporaryUploadByUuidsTask;
use App\Containers\AppSection\Media\Tasks\UpdateMediaTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AttachMediaFromUuidsToModelSubAction extends SubAction
{
    public function __construct(private Kernel $artisan)
    {
    }

    /**
     * Assign all uploaded temporary files to the model.
     */
    public function run(HasInteractsWithMedia $model, ?array $uuids, ?string $collection = null): HasInteractsWithMedia
    {
        if (empty($uuids)) {
            return $model;
        }

        $modelData = [
            'model_id'   => $model->getKey(),
            'model_type' => $model->getMorphClass(),
        ];

        $uploadCollection = app(GetAllTemporaryUploadByUuidsTask::class)->run($uuids);

        $uploadCollection->each(function (TemporaryUpload $file) use ($modelData): void {
            /** @var SupportCollection $mediaCollection */
            $mediaCollection = app(GetAllMediaByModelTask::class)->run($file, $file->collection);

            /** @var Media $media */
            foreach ($mediaCollection as $media) {
                app(UpdateMediaTask::class)->run($media->getKey(), $modelData);
                event(new AttachMediaFromTemporaryUploadEvent($media->getKey()));
            }

            if (config('laravel-media-uploader.regenerate-after-assigning')) {
                $this->artisan->call('media-library:regenerate', [
                    '--ids' => $mediaCollection->pluck('id')->toArray(),
                ]);
            }

            app(DeleteTemporaryUploadByModelTask::class)->run($file);
        });

        $collection ??= MediaCollectionEnum::DEFAULT;

        // The part of the code responsible for delete elements from the Collection,
        // the number of allowed is determined by the parameter $collectionSizeLimit
        if (($collectionSizeLimit = (int)$model->getMediaCollection($collection)?->collectionSizeLimit) !== 0) {
            $collectionMedia = app(GetAllMediaByModelTask::class)->run($model->refresh(), $collection);

            if ($collectionMedia->count() > $collectionSizeLimit) {
                $model->clearMediaCollectionExcept(
                    $collection,
                    $collectionMedia
                        ->reverse()
                        ->take($collectionSizeLimit)
                );
            }
        }

        event(new AttachMediaToModelEvent($modelData['model_id'], $modelData['model_type']));

        return $model;
    }
}
