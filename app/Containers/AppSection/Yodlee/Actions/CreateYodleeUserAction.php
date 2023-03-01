<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Actions;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Data\Transporters\CreateYodleeUserTransporter;
use App\Containers\AppSection\Yodlee\Data\Transporters\YodleePreferenceTransporter;
use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeUserTransporter;
use App\Containers\AppSection\Yodlee\Tasks\CreateApiYodleeUserTask;
use App\Containers\AppSection\Yodlee\Tasks\SaveYodleeMemberTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Str;

class CreateYodleeUserAction extends Action
{
    public function run(CreateYodleeUserTransporter $input): void
    {
        if (config('appSection-yodlee.sandbox.env')) {
            return;
        }

        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        if ($member->yodlee !== null) {
            return;
        }

        $yodleeData = new YodleeUserTransporter([
            'email'       => $member->email,
            'loginName'   => Str::random() . $member->getHashedKey(),
            'preferences' => new YodleePreferenceTransporter(),
        ]);
        $yodleeMember = app(CreateApiYodleeUserTask::class)->run($yodleeData);

        app(SaveYodleeMemberTask::class)->run([
            'member_id'     => $member->getKey(),
            'yodlee_id'     => $yodleeMember['id'],
            'login_name'    => $yodleeMember['loginName'],
        ], $member->getKey());
    }
}
