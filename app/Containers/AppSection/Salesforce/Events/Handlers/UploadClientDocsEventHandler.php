<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsEnum;
use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsTypesEnum;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Client\Models\ClientDocsAdditionalInfo;
use App\Containers\AppSection\Client\Tasks\FindClientByIdTask;
use App\Containers\AppSection\Client\Tasks\FindClientDocsAdditionalInfoTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Events\Events\AttachMediaFromTemporaryUploadEvent;
use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Tasks\FindMediaByIdTask;
use App\Containers\AppSection\Salesforce\Actions\UploadAccountAttachmentAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\UploadAccountAttachmentTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class UploadClientDocsEventHandler implements ShouldQueue
{
    public function handle(AttachMediaFromTemporaryUploadEvent $event): void
    {
        /** @var Media $media */
        $media = app(FindMediaByIdTask::class)->run($event->mediaId);

        if (!($media->model instanceof Client)) {
            return;
        }

        /** @var Client $client */
        $client = app(FindClientByIdTask::class)
            ->withRelations(['member.user'])
            ->run($media->model->getKey());

        $customName = sprintf(
            '%s %s %s.%s',
            $client->member->getName(),
            Str::replace('_', ' ', $media->collection_name),
            $media->created_at?->rawFormat('m-d-Y') ?? '',
            $media->extension
        );

        /** @var ClientDocsAdditionalInfo | null $additionalInfo */
        $additionalInfo = app(FindClientDocsAdditionalInfoTask::class)->run($client->getKey(), $media->getKey());

        if ($additionalInfo !== null) {
            if ($media->collection_name === ClientDocumentsEnum::INVESTMENT_AND_RETIREMENT_ACCOUNTS) {
                $customName = sprintf(
                    '%s %s %s %s.%s',
                    $additionalInfo->name,
                    $additionalInfo->description ?? '',
                    ClientDocumentsTypesEnum::getLabel($additionalInfo->type ?? ''),
                    $media->created_at?->rawFormat('m-d-Y') ?? '',
                    $media->extension
                );
            } else {
                $customName = sprintf(
                    '%s %s %s %s.%s',
                    $additionalInfo->name,
                    $additionalInfo->description ?? '',
                    Str::replace('_', ' ', ClientDocumentsEnum::salesforceType($media->collection_name)),
                    $media->created_at?->rawFormat('m-d-Y') ?? '',
                    $media->extension
                );
            }
        }

        if ($media->collection_name === MediaCollectionEnum::FINANCIAL_FACT_FINDER) {
            $customName = sprintf("%s.%s", $media->name, $media->extension);
        }

        $data = new UploadAccountAttachmentTransporter([
            'member_id'   => $client->member->getKey(),
            'media_id'    => $media->getKey(),
            'custom_name' => $customName,
        ]);

        app(UploadAccountAttachmentAction::class)->run($data);
    }
}
