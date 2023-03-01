<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Data\Transporters;

use App\Containers\AppSection\Documentation\UI\CLI\Commands\GenerateSwaggerOpenApiCommand;
use App\Ship\Parents\Transporters\Transporter;

/**
 * Class SwaggerDataTransporter.
 */
class SwaggerDataTransporter extends Transporter
{
    public GenerateSwaggerOpenApiCommand $command_instance;
}
