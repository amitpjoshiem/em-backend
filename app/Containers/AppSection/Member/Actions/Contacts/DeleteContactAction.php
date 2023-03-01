<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions\Contacts;

use App\Containers\AppSection\Member\Data\Transporters\Contacts\DeleteContactTransporter;
use App\Containers\AppSection\Member\Events\Events\DeleteContactEvent;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\DeleteContactTask;
use App\Containers\AppSection\Member\Tasks\Contacts\GetContactByIdTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Parents\Actions\Action;

class DeleteContactAction extends Action
{
    public function run(DeleteContactTransporter $data): void
    {
        /** @var MemberContact $contact */
        $contact = app(GetContactByIdTask::class)->withRelations(['member'])->run($data->id);

        if ($contact->is_spouse) {
            app(UpdateMemberTask::class)->run($contact->member->id, ['married' => false]);
        }

        app(DeleteContactTask::class)->run($data->id);

        event(new DeleteContactEvent($data->id));
    }
}
