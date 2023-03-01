<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Jobs;

use App\Containers\AppSection\Client\SubActions\CreateClientForMemberSubAction;
use App\Ship\Parents\Jobs\Job;

class CreateClientForMemberJob extends Job
{
    final public function __construct(public int $memberId)
    {
    }

    public function handle(): void
    {
        app(CreateClientForMemberSubAction::class)->run($this->memberId);
    }
}
