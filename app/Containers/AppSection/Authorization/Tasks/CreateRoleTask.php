<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Cache\CacheManager;

class CreateRoleTask extends Task
{
    public function __construct(protected RoleRepository $repository)
    {
    }

    public function run(string $name, string $guardName, ?string $description = null, ?string $displayName = null, int $level = 0): Role
    {
        app(CacheManager::class)->forget(config('permission.cache.key'));

        try {
            return $this->repository->create([
                'name'         => strtolower($name),
                'guard_name'   => $guardName,
                'description'  => $description,
                'display_name' => $displayName,
                'level'        => $level,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
