<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Admin\Actions\SendCreatePasswordSubAction;
use App\Containers\AppSection\User\Data\Transporters\ReSendLeadCreatePasswordTransporter;
use App\Containers\AppSection\User\Exceptions\UserAlreadyVerifyEmailException;
use App\Containers\AppSection\User\Exceptions\UserIsNotClientException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Ship\Parents\Actions\Action;

class ReSendLeadCreatePasswordAction extends Action
{
    public function run(ReSendLeadCreatePasswordTransporter $data): void
    {
        /** @var User $client */
        $client = app(FindUserByEmailTask::class)->run($data->email);

        if (!$client->hasClientRole()) {
            throw new UserIsNotClientException();
        }

        if ($client->email_verified_at !== null) {
            throw new UserAlreadyVerifyEmailException();
        }

        app(SendCreatePasswordSubAction::class)->run($client);
    }
}
