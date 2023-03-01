<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Tasks\FindAllSalesforceUsersTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\SubAction;

class FindAllAssocSalesforceUsersSubAction extends SubAction
{
    public function __construct()
    {
    }

    public function run(): array
    {
        $salesforceUsers = app(FindAllSalesforceUsersTask::class)->run();
        $users           = [];
        foreach ($salesforceUsers as $salesforceUser) {
            $users[$salesforceUser->salesforce_id] = app(FindUserByIdTask::class)->run($salesforceUser->user_id);
        }

        return $users;
    }
}
