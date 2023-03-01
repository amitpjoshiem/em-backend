<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Actions;

use App\Containers\AppSection\Documentation\Tasks\RenderTemplatesTask;
use App\Ship\Parents\Actions\Action;

class GenerateDocumentationAction extends Action
{
    public function run(): string
    {
        // Parse the markdown file.
        return app(RenderTemplatesTask::class)->run();
    }
}
