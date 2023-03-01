<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Media\Models\Media;
use App\Containers\AppSection\Media\Tasks\FindMediaByIdTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\UploadAccountAttachmentTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceAttachment;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceAttachmentsTask;
use App\Ship\Parents\Actions\Action;

class UploadAccountAttachmentAction extends Action
{
    public function __construct()
    {
    }

    public function run(UploadAccountAttachmentTransporter $input): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withrelations([
            'salesforce', 'user',
        ])->run($input->member_id);
        /** @var Media $media */
        $media = app(FindMediaByIdTask::class)->run($input->media_id);

        $userId = $member->user->getKey();

        /** @var SalesforceAttachment $attachment */
        $attachment = app(CreateSalesforceAttachmentsTask::class)->run(
            $member->salesforce->getKey(),
            $member->salesforce::class,
            $media->getKey(),
            $userId,
            $input->custom_name,
        );

        $attachment->api()->create();
    }
}
