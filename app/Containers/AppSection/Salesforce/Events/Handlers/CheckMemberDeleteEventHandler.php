<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\DeleteMemberEvent;
use App\Containers\AppSection\Salesforce\Actions\Account\DeleteAccountAction;
use App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters\DeleteSalesforceAccountTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMemberDeleteEventHandler implements ShouldQueue
{
    public function handle(DeleteMemberEvent $event): void
    {
        $input = new DeleteSalesforceAccountTransporter([
            'member_id' => $event->id,
        ]);
        app(DeleteAccountAction::class)->run($input);
    }
}
