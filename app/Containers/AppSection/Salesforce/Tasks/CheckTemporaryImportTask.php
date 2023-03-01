<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tasks;

use App\Containers\AppSection\Salesforce\Models\SalesforceTemporaryImport;
use App\Containers\AppSection\Salesforce\Services\Objects\AbstractObject;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\Account\SaveImportedAccountSubAction;
use App\Containers\AppSection\Salesforce\SubActions\ChildOpportunity\SaveImportedChildOpportunitySubAction;
use App\Containers\AppSection\Salesforce\SubActions\Contact\SaveImportedContactSubAction;
use App\Containers\AppSection\Salesforce\SubActions\Opportunity\SaveImportedOpportunitySubAction;
use App\Containers\AppSection\Salesforce\SubActions\SaveImportedObjectInterface;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class CheckTemporaryImportTask extends Task
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

    public function run(Collection $temporaryObjects): void
    {
        /** @var SalesforceTemporaryImport $object */
        foreach ($temporaryObjects as $object) {
            /** @var AbstractObject $apiObject */
            $apiObject    = $this->apiService->{$object->object}($object->salesforce_id);
            $objectData   = $apiObject->find();
            $objectAction = app(self::OBJECTS_SAVE_TASKS[$object->object]);
            /** @var User | null $user */
            $user         = app(FindSalesforceUserBySalesforceIdTask::class)->run($object->owner_id);

            if ($user === null) {
                continue;
            }

            if ($objectAction instanceof SaveImportedObjectInterface) {
                $objectAction->run($objectData, $object->salesforce_id, $user->getKey());
                $object->delete();
            }
        }
    }
}
