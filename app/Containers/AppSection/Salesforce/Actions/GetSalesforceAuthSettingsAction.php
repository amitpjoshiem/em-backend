<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceAuthLinkException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceUserNotLoggedInException;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\FindStrictlySalesforceUserTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Parents\Actions\Action;
use Exception;

class GetSalesforceAuthSettingsAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws SalesforceAuthLinkException
     * @throws UserNotFoundException
     */
    public function run(): array
    {
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $auth = true;

        try {
            app(FindStrictlySalesforceUserTask::class)->run($user->getKey());
        } catch (SalesforceUserNotLoggedInException) {
            $auth = false;
        }

        try {
            $link = $this->apiService->user()->getSalesforceAuthLink($user->getHashedKey());
        } catch (Exception) {
            $link = null;
        }

        return [
            'auth'  => $auth,
            'link'  => $link,
        ];
    }
}
