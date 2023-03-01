<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Contracts;

use App\Containers\AppSection\User\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface UserRepositoryInterface.
 */
interface UserRepositoryInterface
{
    /**
     * Returns the cached user for related entities.
     */
    public function getRememberUser(Model $entity): ?User;
}
