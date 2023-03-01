<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Transporters\DeleteClientTokenTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientAlreadyCreateAccountException;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Password;

class DeleteClientTokenAction extends Action
{
    public function run(DeleteClientTokenTransporter $data): void
    {
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($data->member_id);

        if ($member->client === null) {
            throw new ClientNotFoundException();
        }

        if ($member->client->user->email_verified_at !== null) {
            throw new ClientAlreadyCreateAccountException();
        }

        Password::deleteToken($member->client->user);
    }
}
