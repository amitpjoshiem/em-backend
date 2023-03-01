<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\RestoreUserTransporter;
use App\Containers\AppSection\Admin\Jobs\TransferRestoredUserJob;
use App\Containers\AppSection\Admin\Tasks\AdminRestoreUserTask;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Facades\Cache;

class RestoreUserAction extends SubAction
{
    public function run(RestoreUserTransporter $data): void
    {
        /** @var User $restoredUser */
        $restoredUser = app(FindUserByIdTask::class)->run($data->id);

        if ($restoredUser->hasRole(RolesEnum::ADVISOR)) {
            /** @var User $user */
            $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
            $key  = sprintf(config('appSection-user.user_status_key'), $data->id);
            Cache::add($key, 'restoring');
            dispatch(new TransferRestoredUserJob($data->id, $user->getKey()));
        }

        app(AdminRestoreUserTask::class)->run($data->id);
    }
}
