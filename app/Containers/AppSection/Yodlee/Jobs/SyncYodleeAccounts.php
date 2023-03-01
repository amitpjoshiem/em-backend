<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Jobs;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Jobs\Job;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class SyncYodleeAccounts extends Job implements ShouldQueue
{
    public function __construct(protected array $accounts, protected int $memberId)
    {
    }

    public function handle(): void
    {
        $member = app(FindMemberByIdTask::class)->run($this->memberId);
        $data   = [];
        foreach ($this->accounts as $account) {
            $data[] = self::prepareAccountData($account, $member);
        }

        DB::table('yodlee_accounts')->upsert($data, ['yodlee_id', 'user_id']);
    }

    public static function prepareAccountData(array $info, Member $member): array
    {
        $createdAt = Carbon::create($info['createdDate']);
        $createdAt = $createdAt ?: Carbon::now();

        $updatedAt = Carbon::create($info['dataset'][0]['lastUpdated']);
        $updatedAt = $updatedAt ?: Carbon::now();

        return [
            'member_id'             => $member->getKey(),
            'user_id'               => $member->user_id,
            'account_name'          => $info['accountName'] ?? '-',
            'account_status'        => $info['accountStatus'],
            'balance'               => $info['balance']['amount'] ?? 0,
            'yodlee_id'             => $info['id'],
            'include_int_net_worth' => $info['includeInNetWorth'],
            'provider_id'           => $info['providerId'],
            'provider_name'         => $info['providerName'],
            'created_at'            => $createdAt->format('Y-m-d H:i:s'),
            'updated_at'            => $updatedAt->format('Y-m-d H:i:s'),
            'sync_at'               => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
