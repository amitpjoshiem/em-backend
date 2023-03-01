<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Events\Handlers;

use App\Containers\AppSection\Blueprint\Events\Events\ShareDocEvent;
use App\Containers\AppSection\Blueprint\Mails\ShareDocReportMail;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Containers\AppSection\Blueprint\Tasks\FindBlueprintDocByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ShareDocEventHandler implements ShouldQueue
{
    public function handle(ShareDocEvent $event): void
    {
        /** @var BlueprintDoc $doc */
        $doc = app(FindBlueprintDocByIdTask::class)->run($event->docId);

        foreach ($event->emails as $email) {
            Mail::send((new ShareDocReportMail($doc->doc, $email))->onQueue('email'));
        }
    }
}
