<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Events\Handlers;

use Illuminate\Contracts\Queue\ShouldQueue;

class CheckYodleeMemberCreatedEventHandler implements ShouldQueue
{
    public ?string $queue = 'yodlee';

    public function handle(): void
    {
    }
}
