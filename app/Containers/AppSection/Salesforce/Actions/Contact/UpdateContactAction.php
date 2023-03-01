<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Contact;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\GetContactByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\UpdateSalesforceContactTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceContactException;
use App\Containers\AppSection\Salesforce\Tasks\Contact\FindSalesforceContactTask;
use App\Containers\AppSection\Salesforce\Tasks\Contact\SaveSalesforceContactTask;
use App\Ship\Parents\Actions\Action;

class UpdateContactAction extends Action
{
    /**
     * @throws \App\Ship\Exceptions\NotFoundException
     * @throws \App\Containers\AppSection\User\Exceptions\UserNotFoundException
     * @throws \ReflectionException
     * @throws \App\Ship\Exceptions\CreateResourceFailedException
     * @throws \App\Containers\AppSection\Salesforce\Exceptions\SalesforceUpdateException
     */
    public function run(UpdateSalesforceContactTransporter $input): void
    {
        /** @var MemberContact $contact */
        $contact = app(GetContactByIdTask::class)->withRelations(['member'])->run($input->contact_id);

        try {
            app(FindSalesforceContactTask::class)->run($contact->getKey());
        } catch (FindSalesforceContactException) {
            app(SaveSalesforceContactTask::class)->run($contact->member->getKey(), $contact->getKey(), null, $contact->member->salesforce->getKey());
            $contact->salesforce->api()->create();

            return;
        }

        $contact->salesforce->api()->update();
    }
}
