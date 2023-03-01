<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Events\Handlers;

use App\Containers\AppSection\ClientReport\Data\Enums\ClientReportDocsExportStatusEnum;
use App\Containers\AppSection\ClientReport\Events\Events\ShareDocEvent;
use App\Containers\AppSection\ClientReport\Exceptions\ClientReportDocNotSuccessException;
use App\Containers\AppSection\ClientReport\Mails\ShareDocReportMail;
use App\Containers\AppSection\ClientReport\Models\ClientReportsDoc;
use App\Containers\AppSection\ClientReport\Tasks\FindClientReportDocByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ShareDocEventHandler implements ShouldQueue
{
    public function handle(ShareDocEvent $event): void
    {
        /** @var ClientReportsDoc $clientReportDoc */
        $clientReportDoc = app(FindClientReportDocByIdTask::class)->run($event->doc_id);

        if ($clientReportDoc->status !== ClientReportDocsExportStatusEnum::SUCCESS) {
            throw new ClientReportDocNotSuccessException();
        }

        $file = $clientReportDoc->doc;
        foreach ($event->emails as $email) {
            Mail::send((new ShareDocReportMail($file, $email))->onQueue('email'));
        }
    }
}
