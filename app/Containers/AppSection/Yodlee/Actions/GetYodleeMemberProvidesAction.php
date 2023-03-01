<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Actions;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Data\Transporters\GetYodleeProvidersTransporter;
use App\Containers\AppSection\Yodlee\Jobs\SyncYodleeAccounts;
use App\Ship\Parents\Actions\Action;

class GetYodleeMemberProvidesAction extends Action
{
    public function run(GetYodleeProvidersTransporter $input): array
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        if ($member->yodlee === null) {
            return [];
        }

        $providers = $member->yodlee->api()->providers()->getAll();
        $accounts  = $member->yodlee->api()->accounts()->getAll();
        foreach ($accounts as $account) {
            $providers[(int)$account['providerId']]['accounts'][] = $account;
        }

        dispatch(new SyncYodleeAccounts($accounts, $member->getKey()))->onQueue('yodlee');

        $providers = collect($providers);

        return $providers->filter(fn (array $provider): bool => !empty($provider['accounts']))->toArray();
    }
}
