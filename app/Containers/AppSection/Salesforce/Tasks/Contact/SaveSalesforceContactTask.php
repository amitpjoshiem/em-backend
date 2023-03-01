<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Contact;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceContactRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SaveSalesforceContactTask extends Task
{
    public function __construct(protected SalesforceContactRepository $repository)
    {
    }

    public function run(int $memberId, int $memberContactId, ?string $salesforceId, int $accountId): SalesforceContact
    {
        try {
            return $this->repository->updateOrCreate([
                'member_id'     => $memberId,
            ], [
                'member_id'             => $memberId,
                'salesforce_id'         => $salesforceId,
                'salesforce_account_id' => $accountId,
                'contact_id'            => $memberContactId,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
