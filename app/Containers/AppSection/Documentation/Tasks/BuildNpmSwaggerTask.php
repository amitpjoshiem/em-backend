<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Tasks;

use App\Containers\AppSection\Documentation\UI\CLI\Commands\GenerateSwaggerOpenApiCommand;
use App\Ship\Parents\Tasks\Task;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class BuildNpmSwaggerTask.
 */
class BuildNpmSwaggerTask extends Task
{
    public function run(GenerateSwaggerOpenApiCommand $console): void
    {
        $path = base_path();

        $installProcess = new Process(['npm', 'install'], $path, null, null, null);

        $installProcess->run();

        if (!$installProcess->isSuccessful()) {
            $console->error('npm install fail');
            throw new ProcessFailedException($installProcess);
        }

        $runProcess = new Process(['npm', 'run', 'prod'], $path, null, null, null);

        $runProcess->run();

        if (!$runProcess->isSuccessful()) {
            $console->error('npm run prod fail');
            throw new ProcessFailedException($runProcess);
        }

        $console->info(sprintf('Generating Swagger Docs at: %s', $path));
    }
}
