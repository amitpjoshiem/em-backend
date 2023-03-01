<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetPermissionsKeyTask extends Task
{
    public function run(Collection $permissions, ?array $onlyPermissions = null, ?array $exceptPermissions = null): array
    {
        if ($onlyPermissions !== null) {
            $permissions = $permissions->only($onlyPermissions);
        }

        if ($exceptPermissions !== null) {
            $permissions = $permissions->except($exceptPermissions);
        }

        return $this->modelKeys($permissions);
    }

    /**
     * Get the array of primary keys.
     */
    private function modelKeys(Collection $permissions): array
    {
        return array_map(static fn (Permission $permission): int => $permission->getKey(), $permissions->values()->all());
    }
}
