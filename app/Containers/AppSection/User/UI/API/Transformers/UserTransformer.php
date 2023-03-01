<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetUserPhoneStatusTask;
use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

/**
 * Class UserTransformer.
 */
class UserTransformer extends Transformer
{
    use IncludeMediaModelTransformerTrait;

    /**
     * @var array
     */
    protected $availableIncludes = [
        'transferTo',
        'transferFrom',
        'advisor',
        'avatar',
        'roles',
        'company',
    ];

    /**
     * @var string[]
     */
    protected $defaultIncludes = [

    ];

    public function transform(User $user): array
    {
        /** @var Carbon|null $updateAt */
        $updateAt = $user->updated_at;

        $data =  [
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
            'is_deleted'          => $user->deleted_at !== null,
            'status'              => $this->getStatus($user->getKey(), $user->deleted_at !== null),
            'readable_updated_at' => $updateAt?->diffForHumans(),
        ];

        if ($user->relationLoaded('roles')) {
            if ($user->hasRole(RolesEnum::ADVISOR)) {
                $assistants = [];
                $user->assistants?->map(function (User $assistant) use (&$assistants): void {
                    $assistants[] = ['id' => $assistant->getHashedKey(), 'first_name' => $assistant->first_name, 'last_name' => $assistant->last_name];
                });
                $data['assistants'] = $assistants;
            }

            if ($user->hasRole(RolesEnum::ASSISTANT)) {
                $advisors = [];
                $user->advisors?->map(function (User $advisor) use (&$advisors): void {
                    $advisors[] = ['id' => $advisor->getHashedKey(), 'first_name' => $advisor->first_name, 'last_name' => $advisor->last_name];
                });
                $data['advisors'] = $advisors;
            }
        }

        return $data;
    }

    public function includeRoles(User $user): Collection | NullResource
    {
        $user = $user->load('roles');

        if ($user->relationLoaded('roles')) {
            return $this->collection($user->roles, new RoleTransformer());
        }

        return $this->null();
    }

    public function includeCompany(User $user): NullResource | Item
    {
        $user = $user->load('company');

        if ($user->company === null) {
            return $this->null();
        }

        return $this->item($user->company, new CompanyTransformer());
    }

    public function includeAvatar(User $user): Item | NullResource
    {
        if (!$user->relationLoaded('media')) {
            $user = $user->load('media');
        }

        return $this->includeMedia($user);
    }

    private function getStatus(int $userId, bool $deleted): string
    {
        $key = sprintf(config('appSection-user.user_status_key'), $userId);

        if (Cache::has($key)) {
            return 'processing';
        }

        return $deleted ? 'deleted' : 'active';
    }

    public function includeTransferTo(User $user): NullResource|Item
    {
        $user = $user->load('usersTransferTo.toUser');

        if ($user->transferTo() === null) {
            return $this->null();
        }

        return $this->item($user->transferTo(), new self(), include: false);
    }

    public function includeTransferFrom(User $user): NullResource|Collection
    {
        $user = $user->load('usersTransferFrom');

        if ($user->transferFrom()->isEmpty()) {
            return $this->null();
        }

        return $this->collection($user->transferFrom(), new self(), 'transferFrom');
    }

    public function includeAdvisor(User $user): NullResource|Item
    {
        $user = $user->load(['client.member.user']);

        if ($user->client === null) {
            return $this->null();
        }

        return $this->item($user->client->member->user, new self(), include: false);
    }
}
