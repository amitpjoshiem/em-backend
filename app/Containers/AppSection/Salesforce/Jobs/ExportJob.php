<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\SalesforceExportAction;
use App\Ship\Parents\Jobs\Job;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExportJob extends Job
{
    /**
     * @var int
     */
    public $timeout = 1200;

    final public function __construct()
    {
        $this->startJob();
    }

    public function handle(): void
    {
        try {
            app(SalesforceExportAction::class)->run();
        } catch (Exception) {
            Log::error('Can`t Export to Salesforce');
        }

        $this->stopJob();
    }

    private function startJob(): void
    {
        Cache::add(static::getCacheKey(), true, $this->timeout);
    }

    private function stopJob(): void
    {
        Cache::forget(static::getCacheKey());
    }

    public static function isRunning(): bool
    {
        return Cache::has(static::getCacheKey());
    }

    private static function getCacheKey(): string
    {
        return 'salesforce:export';
    }
}
