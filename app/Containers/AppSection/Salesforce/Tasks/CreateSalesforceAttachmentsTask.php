<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAttachmentRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceAttachment;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class CreateSalesforceAttachmentsTask extends Task
{
    public function __construct(protected SalesforceAttachmentRepository $repository)
    {
    }

    public function run(int $objectId, string $objectClass, int $mediaId, int $userId, ?string $customName = null): SalesforceAttachment
    {
        try {
            return $this->repository->create([
                'object_id'     => $objectId,
                'object_class'  => $objectClass,
                'media_id'      => $mediaId,
                'user_id'       => $userId,
                'custom_name'   => $customName,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
