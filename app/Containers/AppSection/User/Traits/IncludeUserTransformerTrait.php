<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\User\Contracts\UserRepositoryInterface;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Transformers\BaseUserTransformer;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\Pivot;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

/**
 * Trait IncludeUserTransformerTrait.
 *
 * @mixin Transformer
 */
trait IncludeUserTransformerTrait
{
    /**
     * This method provide transformed `user` object from cache or directly from database.
     *
     * Use `$entity[$this->includeUserProperty]` for getting user
     * If property `includeUserProperty` is not specified use $entity
     * $entity or $entity[$this->includeUserProperty] - should have `user_id` field and `user` relation
     */
    public function includeUser(Model | Pivot $entity): Item
    {
        /** @var Model|Pivot $mainEntity */
        $mainEntity = empty($this->includeUserProperty) ? $entity : $entity->{$this->includeUserProperty};

        /** @var User $user */
        $user = app(UserRepositoryInterface::class)->getRememberUser($mainEntity);

        return $this->item($user, new BaseUserTransformer());
    }
}
