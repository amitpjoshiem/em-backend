<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Contact;

use App\Containers\AppSection\Member\Tasks\Contacts\DeleteContactTask;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\Contact\DeleteSalesforceContactTask;
use App\Containers\AppSection\Salesforce\Tasks\Contact\FindSalesforceContactBySalesforceIdTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;

class ImportDeletedContactSubAction extends SubAction
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): void
    {
        $deleted = $this->apiService->contact()->getDeleted($startDate, $endDate);

        if (!isset($deleted['deletedRecords'])) {
            return;
        }

        foreach ($deleted['deletedRecords'] as $item) {
            if (isset($item['id'])) {
                $salesforceId = $item['id'];
                /** @var SalesforceContact | null $contact */
                $contact = app(FindSalesforceContactBySalesforceIdTask::class)->run($salesforceId);

                if ($contact !== null) {
                    app(DeleteContactTask::class)->run($contact->contact->id);
                    app(DeleteSalesforceContactTask::class)->run($contact, false);
                }
            }
        }
    }
}
