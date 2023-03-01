<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Data\Transporters\AuthCallbackTransporter;
use App\Containers\AppSection\Salesforce\Events\Events\SalesforceUserLoginEvent;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceUserAlreadyExistException;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\ManageExportExceptionsSubAction;
use App\Containers\AppSection\Salesforce\Tasks\CheckSalesforceUserTask;
use App\Containers\AppSection\Salesforce\Tasks\SaveSalesforceUserIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Exception;
use JsonException;

class AuthenticateUserInSalesforceAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws NotFoundException
     * @throws FindSalesforceAccountException
     * @throws CreateResourceFailedException
     * @throws JsonException
     * @throws SalesforceUserAlreadyExistException
     */
    public function run(AuthCallbackTransporter $input): void
    {
        /** @var User $user */
        $user             = app(FindUserByIdTask::class)->run($input->state);

        try {
            $salesforceUserId = $this->apiService->user()->authenticateUser($input->code);
        } catch (Exception $exception) {
            app(ManageExportExceptionsSubAction::class)->run($exception, SalesforceUser::class, $user->getKey(), 'lo    `gin');

            return;
        }

        if (app(CheckSalesforceUserTask::class)->run($salesforceUserId)) {
            throw new SalesforceUserAlreadyExistException();
        }

        app(SaveSalesforceUserIdTask::class)->run($user->getKey(), $salesforceUserId);
        event(new SalesforceUserLoginEvent($user->getKey(), $salesforceUserId));
    }
}
