<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class BaseUserTransformer.
 */
class BaseUserTransformer extends Transformer
{
    public function transform(User $user): array
    {
        return [
            'object'   => 'User',
            'id'       => $user->getHashedKey(),
            'username' => $user->username,
            'avatar'   => $user->avatar_url,
        ];
    }
}
