<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\CLI\Commands;

use App\Containers\AppSection\Member\Actions\MigrateContactsNameAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class MigrateMemberContactsName extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:contacts:migrate:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        app(MigrateContactsNameAction::class)->run();
    }
}
