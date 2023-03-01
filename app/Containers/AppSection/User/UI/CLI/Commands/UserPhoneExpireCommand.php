<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\CLI\Commands;

use App\Containers\AppSection\User\Actions\CheckExpirePhonesAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class UserPhoneExpireCommand extends ConsoleCommand
{
    /** @var string */
    protected $signature = 'users:phone:expire';

    /** @var string */
    protected $description = 'Check Users With expired Phones';

    public function handle(): void
    {
        app(CheckExpirePhonesAction::class)->run();
    }
}
