<?php

namespace App\Ship\Core\Abstracts\Events\Jobs;

use App\Ship\Core\Abstracts\Events\Interfaces\ShouldHandle;
use App\Ship\Core\Abstracts\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventJob extends Job implements ShouldQueue
{
    public function __construct(public ShouldHandle $handler)
    {
    }

    public function handle(): void
    {
        $this->handler->handle();
    }
}
