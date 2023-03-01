<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Enums\Enum;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Cache\CacheManager;

class CreatePermissionByEnumTask extends Task
{
    public function __construct(protected PermissionRepository $repository)
    {
    }

    public function run(Enum $enum, ?string $displayName = null, ?string $guardName = null): Permission
    {
        app(CacheManager::class)->forget(config('permission.cache.key'));

        $displayName ??= $enum->value;
        $guardName   ??= config('auth.defaults.guard');

        try {
            $permission = $this->repository->create([
                'name'         => $enum->value,
                'description'  => $enum->label,
                'display_name' => $displayName,
                'guard_name'   => $guardName,
            ]);
        } catch (Exception $exception) {
            throw (new CreateResourceFailedException(previous: $exception))->debug($exception);
        }

        return $permission;
    }
}
