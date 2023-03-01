<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authentication\Contracts\AuthenticatedModel;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Ship\Parents\Tasks\Task;

class IfUserAdminTask extends Task
{
    public function __construct(private AuthenticatedModel $authUser)
    {
    }

    public function run(array $adminResponse, array $clientResponse): array
    {
        $user = $this->authUser->getStrictlyAuthUserModel();

        if (app(HasRoleTask::class)->run($user, RolesEnum::admin())) {
            return array_merge($clientResponse, $adminResponse);
        }

        return $clientResponse;
    }
}
