<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Repositories;

use App\Containers\AppSection\User\Contracts\UserRepositoryInterface;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * @var int
     */
    public const USER_TTL = 60;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'          => '=',
        'email'       => '=',
        'username'    => 'like',
        'company.id'  => '=',
        'roles.id'    => 'in',
        'first_name'  => 'like',
        'last_name'   => 'like',
    ];

    /**
     * The cache is updated via UserObserver.
     * We use a relation call 'user', because the above entity can be called from eager loaded 'with'.
     */
    public function getRememberUser(Model $entity): ?User
    {
        return Cache::remember(
            sprintf('user.%s', $entity->user_id),
            self::USER_TTL,
            fn (): ?User => $entity->user
        );
    }
}
