<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\UI\CLI\Commands;

use App\Containers\AppSection\Documentation\Actions\GenerateSwaggerOpenApiAction;
use App\Containers\AppSection\Documentation\Data\Transporters\SwaggerDataTransporter;
use App\Ship\Parents\Commands\ConsoleCommand;

class GenerateSwaggerOpenApiCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiato:swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API Documentations with (Swagger from Swagger-php)';

    public function handle(): void
    {
        $transporter = new SwaggerDataTransporter(['command_instance' => $this]);

        app(GenerateSwaggerOpenApiAction::class)->run($transporter);

        $this->info('Done!');
    }
}
