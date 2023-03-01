<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Models\SalesforceObjectInterface;
use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryExport;
use App\Containers\AppSection\Salesforce\Services\Objects\AbstractObject;
use App\Containers\AppSection\Salesforce\Tasks\GetAllSalesforceExportsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class SalesforceExportAction extends Action
{
    /**
     * @var string[]
     */
    private const ORDER = [
        AbstractObject::CREATE,
        AbstractObject::UPDATE,
        AbstractObject::DELETE,
    ];

    public function __construct()
    {
    }

    public function run(): void
    {
        /** @var Collection<SalesforceTemporaryExport> $exports */
        $exports = app(GetAllSalesforceExportsTask::class)
            ->withRelations(['salesforceObject'])
            ->run()
            ->groupBy('action');
        foreach (self::ORDER as $group) {
            if (!isset($exports[$group])) {
                continue;
            }

            /** @var SalesforceTemporaryExport $export */
            foreach ($exports[$group] as $export) {
                if ($export->salesforceObject instanceof SalesforceObjectInterface && $export->salesforceObject->api()->{$export->action}()) {
                    $export->delete();
                }
            }
        }
    }
}
