<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Events\Handlers;

use App\Containers\AppSection\ClientReport\Actions\GenerateClientReportExcelSubAction;
use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportStatusEnum;
use App\Containers\AppSection\ClientReport\Events\Events\GenerateExcelEvent;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Containers\AppSection\ClientReport\Tasks\FindClientReportDocByIdTask;
use App\Containers\AppSection\ClientReport\Tasks\UpdateClientReportDocTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\UploadFileTask;
use App\Containers\AppSection\Notification\Events\Events\ClientReportDocGeneratedEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateExcelEventHandler implements ShouldQueue
{
    public ?string $queue = 'documents';

    public function handle(GenerateExcelEvent $event): void
    {
        /** @var ClientReportsDoc $clientReportDoc */
        $clientReportDoc = app(FindClientReportDocByIdTask::class)
            ->withMember()
            ->withUser()
            ->run($event->clientReportDocId);

        try {
            $filePath = app(GenerateClientReportExcelSubAction::class)->run($clientReportDoc);
            $media    = app(UploadFileTask::class)
                ->run($filePath, $clientReportDoc->filename, $clientReportDoc, MediaCollectionEnum::CLIENT_REPORT_DOC);
        } catch (Exception) {
            app(UpdateClientReportDocTask::class)->run($clientReportDoc->id, [
                'status' => ClientReportDocsExportStatusEnum::ERROR,
            ]);
            event(new ClientReportDocGeneratedEvent(
                $clientReportDoc->user->getKey(),
                $clientReportDoc->member->getHashedKey(),
                ClientReportDocsExportStatusEnum::ERROR,
                $clientReportDoc->getHashedKey(),
            ));

            return;
        }

        app(UpdateClientReportDocTask::class)->run($clientReportDoc->id, [
            'status'    => ClientReportDocsExportStatusEnum::SUCCESS,
            'media_id'  => $media->id,
        ]);

        event(new ClientReportDocGeneratedEvent(
            $clientReportDoc->user->getKey(),
            $clientReportDoc->member->getHashedKey(),
            ClientReportDocsExportStatusEnum::SUCCESS,
            $clientReportDoc->getHashedKey(),
        ));
    }
}
