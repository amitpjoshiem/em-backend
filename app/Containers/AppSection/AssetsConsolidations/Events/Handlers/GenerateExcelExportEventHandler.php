<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Events\Handlers;

use App\Containers\AppSection\AssetsConsolidations\Actions\GenerateExcelExportAction;
use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportStatusEnum;
use App\Containers\AppSection\AssetsConsolidations\Events\Events\GenerateExcelExportEvent;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Containers\AppSection\AssetsConsolidations\Tasks\UpdateAssetsConsolidationsExportTask;
use App\Containers\AppSection\Media\Actions\CreateTemporaryUploadMediaAction;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Media\Tasks\FindMediaByModelTask;
use App\Containers\AppSection\Notification\Events\Events\ExcelExportFinishedNotificationEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GenerateExcelExportEventHandler implements ShouldQueue
{
    use InteractsWithQueue;

    public ?string $queue = 'documents';

    public function handle(GenerateExcelExportEvent $event): void
    {
        try {
            $filePath = app(GenerateExcelExportAction::class)->run(
                $event->export->getKey(),
                $event->export->member->getKey(),
                $event->export->filename
            );
            $file = new UploadedFile($filePath, $event->export->filename);
            $data = new CreateTemporaryUploadMediaTransporter([
                'file'       => $file,
                'collection' => MediaCollectionEnum::EXCEL_EXPORT,
            ]);
            /** @var TemporaryUpload $temporaryUpload */
            $temporaryUpload = app(CreateTemporaryUploadMediaAction::class)->run($data);

            /** @var AssetsConsolidationsExport $export */
            $export = app(AttachMediaFromUuidsToModelSubAction::class)->run($event->export, [$temporaryUpload->uuid], MediaCollectionEnum::EXCEL_EXPORT);
            Log::info('Finished Successfully');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            app(UpdateAssetsConsolidationsExportTask::class)->run($event->export->getKey(), ['status' => AssetsConsolidationsExportStatusEnum::ERROR]);
            event(new ExcelExportFinishedNotificationEvent(
                $event->export->user->getKey(),
                $event->export->member->getHashedKey(),
                AssetsConsolidationsExportStatusEnum::ERROR,
                $event->export->getHashedKey()
            ));

            $this->fail($exception);

            return;
        }

        /** @var Media $media */
        $media = app(FindMediaByModelTask::class)->run($export, MediaCollectionEnum::EXCEL_EXPORT);
        app(UpdateAssetsConsolidationsExportTask::class)->run($event->export->getKey(), [
            'status'   => AssetsConsolidationsExportStatusEnum::SUCCESS,
            'media_id' => $media->getKey(),
        ]);
        Log::info('before Event');
        event(new ExcelExportFinishedNotificationEvent(
            $event->export->user->getKey(),
            $event->export->member->getHashedKey(),
            AssetsConsolidationsExportStatusEnum::SUCCESS,
            $event->export->getHashedKey()
        ));
    }
}
