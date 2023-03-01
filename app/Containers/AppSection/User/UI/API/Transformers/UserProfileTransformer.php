<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetUserPhoneStatusTask;
use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Support\Carbon;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

/**
 * Class UserProfileTransformer.
 */
class UserProfileTransformer extends Transformer
{
    use IncludeMediaModelTransformerTrait;

    /**
     * @var array
     */
    protected $availableIncludes = [
        'roles',
        'avatar',
    ];

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'avatar',
        'roles',
        'company',
    ];

    public function transform(User $user): array
    {
        /** @var Carbon|null $updateAt */
        $updateAt = $user->updated_at;

        return [
            'object'              => 'User',
            'id'                  => $user->getHashedKey(),
            'username'            => $user->username,
            'email'               => $user->email,
            'first_name'          => $user->first_name,
            'last_name'           => $user->last_name,
            'data_source'         => $user->data_source,
            'is_client'           => $user->is_client,
            'position'            => $user->position,
            'is_email_confirmed'  => $user->hasVerifiedEmail(),
            'phone'               => $user->phone,
            'phone_status'        => app(GetUserPhoneStatusTask::class)->run($user->phone_verified_at?->toImmutable()),
            'npn'                 => $user->npn,
            'updated_at'          => $updateAt,
            'readable_updated_at' => $updateAt !== null ? $updateAt->diffForHumans() : null,
        ];
    }

    public function includeRoles(User $user): Collection
    {
        return $this->collection($user->roles, new RoleTransformer());
    }

    public function includeAvatar(User $user): Item | NullResource
    {
        return $this->includeMedia($user);
    }

    public function includeCompany(User $user): NullResource | Item
    {
        if ($user->company === null) {
            return $this->null();
        }

        return $this->item($user->company, new CompanyTransformer());
    }
}
