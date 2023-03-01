<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions;

use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryImport;
use App\Containers\AppSection\Salesforce\Services\Objects\AbstractObject;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Account\SaveImportedAccountSubAction;
use App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity\SaveImportedChildOpportunitySubAction;
use App\Containers\AppSection\Salesforce\SubActions\Contact\SaveImportedContactSubAction;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\SaveImportedOpportunitySubAction;
use App\Ship\Parents\Actions\SubAction;
use Exception;
use function app;

class ImportTemporaryObjectSubAction extends SubAction
{
    /**
     * @var array<string, SaveImportedObjectInterface>
     */
    public const OBJECTS_SAVE_TASKS = [
        SalesforceApiService::ACCOUNT           => SaveImportedAccountSubAction::class,
        SalesforceApiService::CONTACT           => SaveImportedContactSubAction::class,
        SalesforceApiService::OPPORTUNITY       => SaveImportedOpportunitySubAction::class,
        SalesforceApiService::CHILD_OPPORTUNITY => SaveImportedChildOpportunitySubAction::class,
    ];

    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    public function run(SalesforceTemporaryImport $object, int $userId): void
    {
        /** @var AbstractObject $apiObject */
        $apiObject    = $this->apiService->{$object->object}();

        try {
            $objectData = $apiObject->findById($object->salesforce_id);
        } catch (Exception) {
            $object->delete();

            return;
        }

        $objectAction = app(self::OBJECTS_SAVE_TASKS[$object->object]);

        if ($objectAction instanceof SaveImportedObjectInterface) {
            try {
                $objectAction->run($objectData, $object->salesforce_id, $userId);
            } catch (Exception) {
                return;
            }

            $object->delete();
        }
    }
}
