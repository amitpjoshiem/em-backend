<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Data\Transporters\DeleteMemberTransporter;
use App\Containers\AppSection\Member\Events\Events\DeleteMemberEvent;
use App\Containers\AppSection\Member\Tasks\DeleteMemberTask;
use App\Ship\Parents\Actions\Action;

class DeleteMemberAction extends Action
{
    public function run(DeleteMemberTransporter $memberData): bool
    {
        $success = app(DeleteMemberTask::class)->run($memberData->id);
        event(new DeleteMemberEvent($memberData->id));

        return $success;
    }
}
