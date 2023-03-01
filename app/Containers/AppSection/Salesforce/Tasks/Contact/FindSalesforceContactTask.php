<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks\Contact;

use App\Containers\AppSection\Salesforce\Data\Repositories\SalesforceContactRepository;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceContactException;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Ship\Parents\Tasks\Task;

class FindSalesforceContactTask extends Task
{
    public function __construct(protected SalesforceContactRepository $repository)
    {
    }

    /**
     * @throws FindSalesforceContactException
     */
    public function run(int $contactId): SalesforceContact
    {
        $contact = $this->repository->findByField([
            'contact_id'     => $contactId,
        ])->first();

        if ($contact === null) {
            throw new FindSalesforceContactException();
        }

        return $contact;
    }
}
