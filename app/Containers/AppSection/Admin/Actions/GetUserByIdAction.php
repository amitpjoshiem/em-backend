<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\GetUserByIdTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;

class GetUserByIdAction extends Action
{
    public function run(GetUserByIdTransporter $data): User | null
    {
        return app(FindUserByIdTask::class)
            ->withRelations(['company', 'roles', 'media'])
            ->run($data->id);
    }
}
