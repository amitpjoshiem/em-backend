<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\CheckTemporaryImportAction;
use App\Ship\Parents\Jobs\Job;

class CheckTemporaryImportJob extends Job
{
    final public function __construct()
    {
    }

    public function handle(): void
    {
        app(CheckTemporaryImportAction::class)->run();
    }
}
