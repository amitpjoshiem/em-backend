<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tests\Traits;

use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportStatusEnum;
use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportTypeEnum;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\CreateExportExcelAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsExport;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsExportTask;
use App\Containers\AppSection\Media\Actions\CreateTemporaryUploadMediaAction;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ExcelFileUploaderTestTrait
{
    public function generateExcelExportsFile(int $userId, int $memberId, int $count = 1): void
    {
        Storage::fake('s3');

        for ($i = 0; $i < $count; $i++) {
            /** @psalm-suppress UndefinedInterfaceMethod */
            $tempPath   = Storage::disk('temp')->getDriver()->getAdapter()->getPathPrefix();
            $fileName   = Str::uuid() . '.xlsx';
            $exportData = new CreateExportExcelAssetsConsolidationsTransporter([
                'member_id'  => $memberId,
                'user_id'    => $userId,
                'type'       => AssetsConsolidationsExportTypeEnum::EXCEL,
                'filename'   => $fileName,
                'status'     => AssetsConsolidationsExportStatusEnum::SUCCESS,
                'created_at' => Carbon::now(),
            ]);
            $export = app(CreateAssetsConsolidationsExportTask::class)->run($exportData);
            $this->generateFile($export, $fileName, $tempPath, MediaCollectionEnum::EXCEL_EXPORT);
        }
    }

    public function generateFile(HasInteractsWithMedia $model, string $fileName, string $filePath, string $collection): void
    {
        $file = UploadedFile::fake()->create($filePath . $fileName);
        $data = new CreateTemporaryUploadMediaTransporter([
            'file'       => $file,
            'collection' => $collection,
        ]);
        /** @var TemporaryUpload $temporaryUpload */
        $temporaryUpload = app(CreateTemporaryUploadMediaAction::class)->run($data);

        /** @var AssetsConsolidationsExport $export */
        app(AttachMediaFromUuidsToModelSubAction::class)->run($model, [$temporaryUpload->uuid], $collection);
    }
}
