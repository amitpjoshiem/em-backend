<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\UI\CLI\Commands;

use App\Containers\AppSection\Documentation\Actions\GenerateDocumentationAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class GenerateReadmeCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiato:readme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate README Documentations';

    public function handle(): void
    {
        $path = app(GenerateDocumentationAction::class)->run();

        $this->info(sprintf('Generating README Docs at: %s', $path));
    }
}
