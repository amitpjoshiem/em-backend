<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\CLI\Commands;

use App\Containers\AppSection\Salesforce\Jobs\ExportJob;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Commands\ConsoleCommand;
use Exception;

class SalesforceExport extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesforce:export {--manual}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        $api = new SalesforceApiService();

        try {
            $api->ping()->status();
        } catch (Exception) {
            return;
        }

        if ($this->option('manual')) {
            dispatch(new ExportJob())->onConnection('sync');
        } elseif (!ExportJob::isRunning()) {
            dispatch(new ExportJob())->onQueue('salesforce');
        }
    }
}
