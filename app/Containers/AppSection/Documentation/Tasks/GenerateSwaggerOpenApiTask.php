<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Tasks;

use App\Ship\Parents\Tasks\Task;
use OpenApi\Annotations\OpenApi;
use OpenApi\Generator;

class GenerateSwaggerOpenApiTask extends Task
{
    public function run(): void
    {
        $path       = config('documentation-container.root_folder');
        $htmlFolder = config('documentation-container.html_files');

        if (!is_dir($htmlFolder)) {
            mkdir($htmlFolder);
        }

        /** @var OpenApi | null $openapi */
        $openapi = Generator::scan([$path]);
        $openapi?->saveAs($htmlFolder . '/swagger-collection.yaml', 'yaml');
    }
}
