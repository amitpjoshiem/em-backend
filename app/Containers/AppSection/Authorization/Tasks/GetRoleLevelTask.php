<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class GetRoleLevelTask extends Task
{
    public function run(?UserModel $user): int
    {
        if ($user === null) {
            return 0;
        }

        /** @var MorphToMany $roles */
        $roles = $user->roles();

        /** @var Role|null $role */
        if (($role = $roles->orderBy('level', 'desc')->first()) !== null) {
            return $role->level;
        }

        return 0;
    }
}
