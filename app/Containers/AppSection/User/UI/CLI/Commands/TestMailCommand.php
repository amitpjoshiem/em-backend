<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\CLI\Commands;

use App\Containers\AppSection\User\Mails\TestEmail;
use App\Ship\Parents\Commands\ConsoleCommand;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends ConsoleCommand
{
    /** @var string */
    protected $signature = 'mail:test';

    /** @var string */
    protected $description = 'Check Users With expired Phones';

    public function handle(): void
    {
        Mail::send((new TestEmail('test@test.com'))->onConnection('sync'));
    }
}
