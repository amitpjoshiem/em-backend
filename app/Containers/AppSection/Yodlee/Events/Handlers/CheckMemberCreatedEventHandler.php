<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Events\Handlers;

use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Yodlee\Actions\CreateYodleeUserAction;
use App\Containers\AppSection\Yodlee\Data\Transporters\CreateYodleeUserTransporter;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMemberCreatedEventHandler implements ShouldQueue
{
    public ?string $queue = 'yodlee';

    public function handle(CreateMemberEvent $event): void
    {
        $data = new CreateYodleeUserTransporter(['member_id' => $event->entity->getKey()]);
        app(CreateYodleeUserAction::class)->run($data);
    }
}
