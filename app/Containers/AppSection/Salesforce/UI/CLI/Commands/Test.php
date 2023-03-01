<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\CLI\Commands;

use App\Containers\AppSection\Client\Events\Events\SubmitClientEvent;
use App\Containers\AppSection\Notification\Events\Events\ClientSubmitEvent;
use App\Ship\Parents\Commands\ConsoleCommand;

class Test extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        event(new SubmitClientEvent(1));
    }
}
