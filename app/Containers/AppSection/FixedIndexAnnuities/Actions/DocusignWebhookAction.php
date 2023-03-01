<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Actions;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Enums\DocusignEventsEnum;
use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\DocusignWebhookTransporter;
use App\Containers\AppSection\FixedIndexAnnuities\SubActions\DocusignEnvelopCompletedSubAction;
use App\Containers\AppSection\FixedIndexAnnuities\SubActions\DocusignRecipientCompletedSubAction;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Log;

class DocusignWebhookAction extends Action
{
    public function run(DocusignWebhookTransporter $data): void
    {
        Log::info('Docusign Webhook', ['type' => $data->event]);

        if ($data->event === DocusignEventsEnum::RECIPIENT_COMPLETED) {
            app(DocusignRecipientCompletedSubAction::class)->run($data->data);
        } elseif ($data->event === DocusignEventsEnum::ENVELOPE_COMPLETED) {
            app(DocusignEnvelopCompletedSubAction::class)->run($data->data);
        }
    }
}
