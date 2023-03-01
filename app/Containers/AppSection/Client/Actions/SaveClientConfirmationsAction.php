<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientConfirmationTransporter;
use App\Containers\AppSection\Client\Data\Transporters\SaveClientConfirmationTransporter;
use App\Containers\AppSection\Client\Exceptions\ClientNotFoundException;
use App\Containers\AppSection\Client\Models\ClientConfirmation;
use App\Containers\AppSection\Client\Tasks\SaveClientConfirmationTask;
use App\Containers\AppSection\Client\Tasks\SaveClientTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\DB;

class SaveClientConfirmationsAction extends Action
{
    public function run(SaveClientConfirmationTransporter $confirmationData): OutputClientConfirmationTransporter
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->client === null) {
            throw new ClientNotFoundException();
        }

        if (isset($confirmationData->consultation)) {
            app(SaveClientTask::class)->run($user->getKey(), $user->client->member->getKey(), [
                'consultation' => $confirmationData->consultation,
            ]);
        }

        if (isset($confirmationData->currently_have)) {
            DB::beginTransaction();
            foreach ($confirmationData->currently_have as $item => $value) {
                app(SaveClientConfirmationTask::class)->run([
                    'group'     => ClientConfirmation::CURRENTLY_HAVE_GROUP,
                    'item'      => $item,
                    'value'     => $value,
                    'member_id' => $user->client->member->getKey(),
                    'client_id' => $user->client->getKey(),
                ]);
            }

            DB::commit();
        }

        if (isset($confirmationData->more_info_about)) {
            DB::beginTransaction();
            foreach ($confirmationData->more_info_about as $item => $value) {
                app(SaveClientConfirmationTask::class)->run([
                    'group'     => ClientConfirmation::MORE_INFO_ABOUT_GROUP,
                    'item'      => $item,
                    'value'     => $value,
                    'member_id' => $user->client->member->getKey(),
                    'client_id' => $user->client->getKey(),
                ]);
            }

            DB::commit();
        }

        return app(GetClientConfirmationSubAction::class)->run($user->client);
    }
}
