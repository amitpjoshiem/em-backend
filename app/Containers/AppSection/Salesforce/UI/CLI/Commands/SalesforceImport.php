<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\CLI\Commands;

use App\Containers\AppSection\Salesforce\Jobs\CheckTemporaryImportJob;
use App\Containers\AppSection\Salesforce\Jobs\ImportAccountsJob;
use App\Containers\AppSection\Salesforce\Jobs\ImportAnnualReviewsJob;
use App\Containers\AppSection\Salesforce\Jobs\ImportChildOpportunitiesJob;
use App\Containers\AppSection\Salesforce\Jobs\ImportContactsJob;
use App\Containers\AppSection\Salesforce\Jobs\ImportObjectsJob;
use App\Containers\AppSection\Salesforce\Jobs\ImportOpportunitiesJob;
use App\Containers\AppSection\Salesforce\Models\SalesforceInit;
use App\Containers\AppSection\Salesforce\Tasks\FindSalesforceImportTask;
use App\Ship\Parents\Commands\ConsoleCommand;
use Carbon\CarbonImmutable;

class SalesforceImport extends ConsoleCommand
{
    /**
     * @var array<class-string<ImportObjectsJob>>
     */
    private const IMPORT_OBJECTS_JOBS = [
        ImportAccountsJob::class,
        ImportContactsJob::class,
        ImportOpportunitiesJob::class,
        ImportChildOpportunitiesJob::class,
        ImportAnnualReviewsJob::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesforce:import {--manual}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        $startDate = CarbonImmutable::now()->subDays(4);
        $endDate   = CarbonImmutable::now();
        foreach (self::IMPORT_OBJECTS_JOBS as $job) {
            $importData = app(FindSalesforceImportTask::class)->run($job);

            if ($importData !== null) {
                $startDate  = $importData->end_date;
            }

            $this->dispatchJob($job, $startDate, $endDate);
        }

        SalesforceInit::sync();

        if ($this->option('manual')) {
            dispatch(new CheckTemporaryImportJob())->onConnection('sync');
        } else {
            dispatch(new CheckTemporaryImportJob());
        }
    }

    /**
     * @param class-string<ImportObjectsJob> $job
     */
    private function dispatchJob(string $job, CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        if ($this->option('manual')) {
            dispatch(new $job($startDate, $endDate))->onConnection('sync');
        } elseif (!$job::isRunning()) {
            dispatch(new $job($startDate, $endDate))->onQueue('salesforce');
        }
    }
}
