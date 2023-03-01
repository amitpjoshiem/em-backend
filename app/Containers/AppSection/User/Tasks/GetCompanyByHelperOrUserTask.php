<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Exceptions\UserHelperNotCreatedException;
use App\Containers\AppSection\User\Helper\UserHelper;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class GetCompanyByHelperOrUserTask extends Task
{
    public function __construct()
    {
    }

    public function run(User $user): int
    {
        try {
            $userHelper = UserHelper::instance();

            return $userHelper->company()->getKey();
        } catch (UserHelperNotCreatedException) {
            return $user->company->getKey();
        }
    }
}
