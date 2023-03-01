<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\UpdateContactTransporter;
use App\Containers\AppSection\Member\Events\Events\UpdateContactEvent;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\GetContactByIdTask;
use App\Containers\AppSection\Member\Tasks\Contacts\RemoveSpouseMarkContactTask;
use App\Containers\AppSection\Member\Tasks\Contacts\UpdateContactTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Parents\Actions\Action;

class UpdateContactAction extends Action
{
    public function run(UpdateContactTransporter $data): MemberContact
    {
        /** @var MemberContact $contact */
        $contact = app(GetContactByIdTask::class)->run($data->id);

        if (isset($data->is_spouse) && $data->is_spouse) {
            if (!$contact->member->married) {
                app(UpdateMemberTask::class)->run($contact->member->id, ['married' => true]);
            }

            app(RemoveSpouseMarkContactTask::class)->run($contact->member->id);
        }

        $contact = app(UpdateContactTask::class)->run($data->except('id')->toArray(), $data->id);

        event(new UpdateContactEvent($contact));

        return $contact;
    }
}
