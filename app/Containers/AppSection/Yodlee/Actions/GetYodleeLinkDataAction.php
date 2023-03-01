<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Actions;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Data\Transporters\WebYodleeLinkTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\NotFoundMemberYodleeAccountException;
use App\Containers\AppSection\Yodlee\Tasks\SaveYodleeMemberTask;
use App\Ship\Parents\Actions\Action;

class GetYodleeLinkDataAction extends Action
{
    public function run(WebYodleeLinkTransporter $input): array
    {
        $member = app(FindMemberByIdTask::class)->run($input->id);

        if ($member->yodlee === null) {
            throw new NotFoundMemberYodleeAccountException();
        }

        $sandbox = config('appSection-yodlee.sandbox.env');
        $creds   = $sandbox ? config('appSection-yodlee.sandbox.creds') : [];

        app(SaveYodleeMemberTask::class)->run(['link_used' => true], $member->getKey());

        return [
            'token'         => $member->yodlee->api()->getUserToken(),
            'fastlink'      => config('appSection-yodlee.fastlink'),
            'sandbox'       => $sandbox,
            'sandbox_creds' => $creds,
        ];
    }
}
