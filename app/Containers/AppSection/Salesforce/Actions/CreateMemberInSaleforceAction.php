<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Actions\Account\CreateAccountAction;
use App\Containers\AppSection\Salesforce\Actions\Contact\CreateContactAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters\CreateSalesforceAccountTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters\CreateSalesforceContactTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\CreateMemberInSaleforceTransporter;
use App\Ship\Parents\Actions\Action;

class CreateMemberInSaleforceAction extends Action
{
    public function run(CreateMemberInSaleforceTransporter $data): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations(['spouse', 'contacts'])->run($data->member_id);
        $input  = new CreateSalesforceAccountTransporter([
            'member_id' => $data->member_id,
        ]);
        app(CreateAccountAction::class)->run($input);

        if ($member->married) {
            $input = new CreateSalesforceContactTransporter([
                'contact_id' => $member->spouse->getKey(),
            ]);
            app(CreateContactAction::class)->run($input);
        }
    }
}
