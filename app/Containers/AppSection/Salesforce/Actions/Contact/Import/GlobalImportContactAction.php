<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Contact\Import;

use App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Contact\SaveImportedContactSubAction;
use App\Ship\Parents\Actions\Action;
use function app;

class GlobalImportContactAction extends Action implements GlobalImportObjectInterface
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(): void
    {
        $contacts = $this->apiService->contact()->globalImport();

        foreach ($contacts['records'] as $contact) {
            if ($contact['IsDeleted'] === true) {
                continue;
            }

            app(SaveImportedContactSubAction::class)->run($contact, $contact['Id']);
        }
    }
}
