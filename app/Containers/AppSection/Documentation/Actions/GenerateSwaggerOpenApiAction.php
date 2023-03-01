<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Actions;

use App\Containers\AppSection\Documentation\Data\Transporters\SwaggerDataTransporter;
use App\Containers\AppSection\Documentation\Tasks\BuildNpmSwaggerTask;
use App\Containers\AppSection\Documentation\Tasks\GenerateSwaggerOpenApiTask;
use App\Ship\Parents\Actions\Action;

class GenerateSwaggerOpenApiAction extends Action
{
    public function run(SwaggerDataTransporter $data): void
    {
        $console = $data->command_instance;

        app(BuildNpmSwaggerTask::class)->run($console);

        app(GenerateSwaggerOpenApiTask::class)->run();
    }
}
