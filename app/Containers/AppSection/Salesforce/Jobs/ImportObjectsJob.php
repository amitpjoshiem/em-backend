<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Jobs;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceSuccessfullyImportObjectEvent;
use App\Containers\AppSection\Salesforce\SubActions\ManageImportExceptionsSubAction;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceImportTask;
use App\Containers\AppSection\Salesforce\Tasks\DeleteAllSalesforceObjectExceptionsTask;
use App\Ship\Parents\Jobs\Job;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Support\Facades\Cache;

abstract class ImportObjectsJob extends Job
{
    /**
     * @var int
     */
    public $tries = 1;

    /**
     * @var int
     */
    public $timeout = 3600;

    final public function __construct(protected CarbonImmutable $start, protected CarbonImmutable $end)
    {
        $this->startJob();
    }

    abstract public function getImportAction(): ImportObjectInterface;

    abstract public static function getObjectName(): string;

    abstract public static function getObjectModel(): string;

    public function handle(): void
    {
        try {
            $this->getImportAction()->run($this->start, $this->end);
        } catch (Exception $exception) {
            app(ManageImportExceptionsSubAction::class)->run($exception);
            $this->stopJob();

            return;
        }

        app(CreateSalesforceImportTask::class)->run(static::class, (int)$this->start->timestamp, (int)$this->end->timestamp);
        app(DeleteAllSalesforceObjectExceptionsTask::class)->run(static::getObjectModel());
        $this->stopJob();
        event(new SalesforceSuccessfullyImportObjectEvent(static::class));
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
        return sprintf('salesforce:import:%s', static::getObjectName());
    }
}
