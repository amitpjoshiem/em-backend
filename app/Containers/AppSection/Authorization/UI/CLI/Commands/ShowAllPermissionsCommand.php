<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\CLI\Commands;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Permission\Commands\Show;
use Spatie\Permission\Contracts\Permission as PermissionInterface;
use Spatie\Permission\Contracts\Role as RoleInterface;

class ShowAllPermissionsCommand extends Show
{
    public function handle(): void
    {
        /** @var Permission $permissionClass */
        $permissionClass = app(PermissionInterface::class);
        /** @var Role $roleClass */
        $roleClass       = app(RoleInterface::class);

        $style = $this->argument('style') ?? 'default';
        $guard = $this->argument('guard');

        if ($guard) {
            $guards = Collection::make([$guard]);
        } else {
            $guards = $permissionClass::pluck('guard_name')->merge($roleClass::pluck('guard_name'))->unique();
        }

        foreach ($guards as $guard) {
            $this->info(sprintf('Guard: %s', $guard));

            /** @var Builder $builder */
            $builder = $roleClass::whereGuardName($guard);
            /** @var Collection $roles */
            $roles = $builder->orderBy('name')->get()->mapWithKeys(static fn (Role $role) => [$role->name => $role->permissions->pluck('name')]);

            /** @var Builder $builder */
            $builder = $permissionClass::whereGuardName($guard);
            /** @var Collection $permissions */
            $permissions = $builder->orderBy('name')->pluck('name');

            $body = $permissions->map(fn (string $permission): Collection => $roles->map(static fn (Collection $role_permissions): string => $role_permissions->contains($permission) ? ' ✔' : ' ✘')->prepend($permission));

            $this->table(
                $roles->keys()->prepend('')->toArray(),
                $body->toArray(),
                \is_string($style) ? $style : 'default'
            );
        }
    }
}
