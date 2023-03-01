<?php

declare(strict_types=1);

namespace AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceAttachmentRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceAttachment;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateSalesforceAttachmentsTask extends Task
{
    public function __construct(protected SalesforceAttachmentRepository $repository)
    {
    }

    public function run(int $id, array $data): SalesforceAttachment
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(previous: $exception);
        }
    }
}
