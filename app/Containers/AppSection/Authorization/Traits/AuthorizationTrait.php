<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Traits;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait AuthorizationTrait
{
    public function getUser(): ?Authenticatable
    {
        return app(GetAuthenticatedUserTask::class)->run();
    }

    public function hasAdminRole(): bool
    {
        return $this->hasRole(RolesEnum::ADMIN);
    }

    public function hasAdvisorRole(): bool
    {
        return $this->hasRole(RolesEnum::ADVISOR);
    }

    public function hasClientRole(): bool
    {
        return $this->hasRole(RolesEnum::CLIENT);
    }

    /**
     * Return the "highest" role of a user (0 if the user does not have any role).
     */
    public function getRoleLevel(): int
    {
        /** @var MorphToMany $roles */
        $roles = $this->roles();

        return ($role = $roles->orderBy('level', 'desc')->first()) ? $role->level : 0;
    }
}
