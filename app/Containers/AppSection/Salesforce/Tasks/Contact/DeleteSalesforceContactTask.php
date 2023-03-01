<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Contact;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceContactRepository;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteSalesforceContactTask extends Task
{
    public function __construct(protected SalesforceContactRepository $repository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(SalesforceContact $contact, bool $withApi = true): bool
    {
        if ($withApi) {
            $contact->api()->delete();
        }

        try {
            return (bool)$this->repository->delete($contact->getKey());
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
