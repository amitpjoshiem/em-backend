<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\CreateContactTransporter;
use App\Containers\AppSection\Member\Events\Events\CreateContactEvent;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\CreateContactTask;
use App\Containers\AppSection\Member\Tasks\Contacts\RemoveSpouseMarkContactTask;
use App\Ship\Parents\Actions\Action;

class CreateContactAction extends Action
{
    public function run(CreateContactTransporter $data): MemberContact
    {
        if (isset($data->is_spouse) && $data->is_spouse) {
            app(RemoveSpouseMarkContactTask::class)->run($data->member_id);
        }

        $contact = app(CreateContactTask::class)->run($data->toArray());

        event(new CreateContactEvent($contact));

        return $contact;
    }
}
