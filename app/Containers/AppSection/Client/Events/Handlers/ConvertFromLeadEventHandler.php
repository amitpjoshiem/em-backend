<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Events\Handlers;

use App\Containers\AppSection\Client\Tasks\UpdateClientByMemberIdTask;
use App\Containers\AppSection\Member\Events\Events\ConvertFromLeadMemberEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConvertFromLeadEventHandler implements ShouldQueue
{
    public function handle(ConvertFromLeadMemberEvent $event): void
    {
        /** @FIXME Remove Readonly but maybe in future they want to get back readonly */
        app(UpdateClientByMemberIdTask::class)->run($event->id, [
            'converted_from_lead' => now(),
            //            'readonly'            => true,
        ]);
    }
}
