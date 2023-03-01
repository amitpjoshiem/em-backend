<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\UI\CLI\Commands;

use App\Containers\AppSection\Yodlee\Jobs\SyncYodleeAccounts;
use App\Containers\AppSection\Yodlee\Models\YodleeMember;
use App\Containers\AppSection\Yodlee\Tasks\GetAllYodleeMembersTask;
use App\Ship\Parents\Commands\ConsoleCommand;

class YodleeImport extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yodlee:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        $yodleeMembers = app(GetAllYodleeMembersTask::class)->run();
        /** @var YodleeMember $yodleeMember */
        foreach ($yodleeMembers as $yodleeMember) {
            $accounts = $yodleeMember->api()->accounts()->getAll();
            dispatch(new SyncYodleeAccounts($accounts, $yodleeMember->member_id))->onQueue('yodlee');
        }
    }
}
