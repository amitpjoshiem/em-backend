<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\CLI\Commands;

use App\Containers\AppSection\Member\Actions\ForceDeleteMemberWithDependenciesAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class DeleteMemberCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        while (true) {
            $id = $this->ask('Member ID');

            app(ForceDeleteMemberWithDependenciesAction::class)->run((int)$id);
        }
    }
}
