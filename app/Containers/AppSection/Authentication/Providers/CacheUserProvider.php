<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Containers\AppSection\User\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Cache;

class CacheUserProvider extends EloquentUserProvider
{
    /**
     * @return void
     */
    public function __construct(Hasher $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param string $identifier
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        return Cache::get(sprintf('user.%s', $identifier)) ?? parent::retrieveById($identifier);
    }
}
