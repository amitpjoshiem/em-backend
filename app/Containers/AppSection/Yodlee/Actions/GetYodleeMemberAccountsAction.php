<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Actions;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Data\Transporters\GetYodleeAccountsTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\NotFoundMemberYodleeAccountException;
use App\Containers\AppSection\Yodlee\Jobs\SyncYodleeAccounts;
use App\Ship\Parents\Actions\Action;

class GetYodleeMemberAccountsAction extends Action
{
    public function run(GetYodleeAccountsTransporter $input): array
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        if ($member->yodlee === null) {
            throw new NotFoundMemberYodleeAccountException();
        }

        $accounts = $member->yodlee->api()->accounts()->getAccountsByProviderId($input->provider_id);

        dispatch(new SyncYodleeAccounts($accounts, $member->getKey()))->onQueue('yodlee');

        return $accounts;
    }
}
