<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\DeleteUserTransporter;
use App\Containers\AppSection\Admin\Jobs\TransferFromDeletedUserJob;
use App\Containers\AppSection\Admin\Tasks\AdminDeleteUserTask;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class DeleteUserAction extends SubAction
{
    public function run(DeleteUserTransporter $data): void
    {
        /** @var User $deletedUser */
        $deletedUser = app(FindUserByIdTask::class)->run($data->id);

        if ($deletedUser->hasRole(RolesEnum::ADVISOR) && !isset($data->transfer_to)) {
            throw ValidationException::withMessages(['transfer_to' => 'Required for Advisor']);
        }

        if ($deletedUser->hasRole(RolesEnum::ADVISOR) && $data->transfer_to !== null) {
            /** @var User $user */
            $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

            $key = sprintf(config('appSection-user.user_status_key'), $data->id);
            Cache::add($key, 'deleting');
            dispatch(new TransferFromDeletedUserJob($data->id, $data->transfer_to, $user->getKey()));
        }

        app(AdminDeleteUserTask::class)->run($data->id);
    }
}
