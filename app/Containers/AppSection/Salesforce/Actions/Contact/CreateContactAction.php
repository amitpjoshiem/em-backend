<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Contact;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\GetContactByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\CreateSalesforceContactTransporter;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountTask;
use App\Containers\AppSection\Salesforce\Tasks\Contact\SaveSalesforceContactTask;
use App\Ship\Parents\Actions\Action;

class CreateContactAction extends Action
{
    /**
     * @throws \App\Ship\Exceptions\NotFoundException
     * @throws \App\Containers\AppSection\Salesforce\Exceptions\SalesforceCreateException
     * @throws \App\Containers\AppSection\User\Exceptions\UserNotFoundException
     */
    public function run(CreateSalesforceContactTransporter $input): void
    {
        /** @var MemberContact $contact */
        $contact = app(GetContactByIdTask::class)->withRelations(['member'])->run($input->contact_id);

        $account = app(FindSalesforceAccountTask::class)->run($contact->member->getKey());

        app(SaveSalesforceContactTask::class)->run($contact->member->getKey(), $contact->getKey(), null, $account->getKey());

        $contact->salesforce->api()->create();
    }
}
