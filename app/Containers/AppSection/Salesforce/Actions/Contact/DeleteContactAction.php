<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Contact;

use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\DeleteSalesforceContactTransporter;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Containers\AppSection\Salesforce\Tasks\Contact\FindSalesforceContactTask;
use App\Ship\Parents\Actions\Action;

class DeleteContactAction extends Action
{
    public function run(DeleteSalesforceContactTransporter $input): void
    {
        /** @var SalesforceContact $contact */
        $contact = app(FindSalesforceContactTask::class)->run($input->contact_id);

        $contact->api()->delete();
        $contact->delete();
    }
}
