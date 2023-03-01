<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Account\Import;

use App\Containers\AppSection\Salesforce\Actions\ImportObjectInterface;
use App\Containers\AppSection\Salesforce\SubActions\Account\ImportDeletedAccountSubAction;
use App\Containers\AppSection\Salesforce\SubActions\Account\ImportUpdatedAccountSubAction;
use App\Ship\Parents\Actions\Action;
use Carbon\CarbonImmutable;
use function app;

class ImportAccountAction extends Action implements ImportObjectInterface
{
    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        app(ImportDeletedAccountSubAction::class)->run($startDate, $endDate);
        app(ImportUpdatedAccountSubAction::class)->run($startDate, $endDate);
    }
}
