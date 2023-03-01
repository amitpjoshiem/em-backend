<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Contact;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\FindAllSalesforceContactTransporter;
use App\Ship\Parents\Actions\Action;

class FindAllContactAction extends Action
{
    public function run(FindAllSalesforceContactTransporter $input): array
    {
        $member   = app(FindMemberByIdTask::class)->run($input->member_id);
        $contacts = [];

        if ($member->married) {
            $contacts['spouse'] = $member->salesforce->contact->api()->find();
        }

        return $contacts;
    }
}
