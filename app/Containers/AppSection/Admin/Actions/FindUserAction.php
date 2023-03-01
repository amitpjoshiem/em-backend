<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;

class FindUserAction extends Action
{
    public function run(int $userId): ?User
    {
        return app(FindUserByIdTask::class)->withRelations(['roles', 'company', 'advisors', 'assistants'])->run($userId);
    }
}
