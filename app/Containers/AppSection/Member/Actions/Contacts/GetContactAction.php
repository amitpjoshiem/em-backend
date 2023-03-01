<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\GetContactTransporter;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\GetContactByIdTask;
use App\Ship\Parents\Actions\Action;

class GetContactAction extends Action
{
    public function run(GetContactTransporter $data): MemberContact
    {
        return app(GetContactByIdTask::class)->run($data->id);
    }
}
