<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Contact\Import;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Contact\ImportDeletedContactSubAction;
use App\Containers\AppSection\Salesforce\SubActions\Contact\ImportUpdatedContactSubAction;
use App\Ship\Parents\Actions\Action;
use Carbon\CarbonImmutable;
use function app;

class ImportContactAction extends Action implements ImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        app(ImportDeletedContactSubAction::class)->run($startDate, $endDate);
        app(ImportUpdatedContactSubAction::class)->run($startDate, $endDate);
    }
}
