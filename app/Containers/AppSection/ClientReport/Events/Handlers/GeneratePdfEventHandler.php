<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Events\Handlers;

use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportStatusEnum;
use App\Containers\AppSection\ClientReport\Events\Events\GeneratePdfEvent;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Containers\AppSection\ClientReport\Tasks\FindClientReportDocByIdTask;
use App\Containers\AppSection\ClientReport\Tasks\GetAllClientReportsTask;
use App\Containers\AppSection\ClientReport\Tasks\UpdateClientReportDocTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\UploadFileTask;
use App\Containers\AppSection\Notification\Events\Events\ClientReportDocGeneratedEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use mikehaertl\wkhtmlto\Pdf;

class GeneratePdfEventHandler implements ShouldQueue
{
    public ?string $queue = 'documents';

    public function handle(GeneratePdfEvent $event): void
    {
        /** @var ClientReportsDoc $clientReportDoc */
        $clientReportDoc = app(FindClientReportDocByIdTask::class)
            ->withMember()
            ->withUser()
            ->run($event->clientReportDocId);

        try {
            $filePath = $this->createPdf($clientReportDoc, $event->contracts);
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

    private function createPdf(ClientReportsDoc $clientReportDoc, ?array $contracts): string
    {
        /** @var Collection $clientReports */
        $clientReports = app(GetAllClientReportsTask::class)
            ->filterByMember($clientReportDoc->member->getKey())
            ->filterByContractsId($contracts)
            ->orderByOriginationDate()
            ->run();
        $reportsPerPage = config('appSection-clientReport.reports_per_page');
        $view           = view('appSection@clientReport::pdf', [
            'name'               => $clientReportDoc->member->name,
            'clientReportsPages' => $clientReports->chunk($reportsPerPage)->toArray(),
            'year'               => now()->year,
        ])->render();
        $tmp     = sprintf('%s/%s', config('appSection-clientReport.pdf_report_tmp_path'), $clientReportDoc->filename);
        $options = [
            'user-style-sheet' => resource_path('assets/css/client_report.css'),
            'run-script'       => [
                resource_path('assets/js/client_report.js'),
            ],
            'orientation' => 'landscape',
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,

            'disable-smart-shrinking',
        ];
        $pdf = new Pdf($options);
        $pdf->addPage($view);
        $pdf->saveAs($tmp);

        return $tmp;
    }
}
