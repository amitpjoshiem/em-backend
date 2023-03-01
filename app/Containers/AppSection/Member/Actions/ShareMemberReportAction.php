<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Data\Transporters\ShareMemberReportTransporter;
use App\Containers\AppSection\Member\Events\Events\ShareMemberReportEvent;
use App\Containers\AppSection\Member\Exceptions\NotFoundMemberReportException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class ShareMemberReportAction extends Action
{
    public function run(ShareMemberReportTransporter $shareData): void
    {
        if ($shareData->uuids === null) {
            throw new NotFoundMemberReportException();
        }

        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        event(new ShareMemberReportEvent($shareData->uuids, $shareData->emails, $user->getKey()));
    }
}
