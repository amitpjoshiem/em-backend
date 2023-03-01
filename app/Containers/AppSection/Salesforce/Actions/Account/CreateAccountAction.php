<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Account;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters\CreateSalesforceAccountTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceCreateException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountTask;
use App\Containers\AppSection\Salesforce\Tasks\Account\SaveSalesforceAccountTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use JsonException;

class CreateAccountAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws NotFoundException
     * @throws SalesforceCreateException
     * @throws UserNotFoundException
     * @throws JsonException
     * @throws CreateResourceFailedException
     */
    public function run(CreateSalesforceAccountTransporter $input): SalesforceAccount
    {
        /** @var Member $member */
        $member  = app(FindMemberByIdTask::class)->run($input->member_id);

        try {
            app(FindSalesforceAccountTask::class)->run($member->getKey());
        } catch (FindSalesforceAccountException) {
            $account = app(SaveSalesforceAccountTask::class)->run($member->getKey());

            $this->apiService->account($account)->create();

            return $account;
        }

        return $member->salesforce;
    }
}
