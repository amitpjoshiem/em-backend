<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\AccountTransformer;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

class MemberTransformer extends Transformer
{
    use IncludeMediaModelTransformerTrait;

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'spouse',
        'contacts',
        'employment_history',
        'house',
        'other',
        'client_user',
        'avatar',
        'owner',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [
        'salesforce',
    ];

    public function transform(Member $member): array
    {
        /** @var User $authUser */
        $authUser = app(GetStrictlyAuthenticatedUserTask::class)->run();

        /** @psalm-suppress */
        $response = [
            'id'                        => $member->getHashedKey(),
            'type'                      => $member->type,
            'name'                      => $member->name,
            'email'                     => $member->email,
            'birthday'                  => $member->birthday?->format('Y-m-d'),
            'age'                       => $member->getAge(),
            'phone'                     => $member->phone,
            'married'                   => $member->married,
            'retired'                   => $member->retired ?: false,
            'retirement_date'           => $member->retirement_date?->format('Y-m-d'),
            'address'                   => $member->address,
            'city'                      => $member->city,
            'state'                     => $member->state,
            'zip'                       => $member->zip,
            'step'                      => $member->step,
            'onboarding'                => $this->calculateOnBoarding($member),
            'notes'                     => $member->notes,
            'biggest_financial_concern' => $member->biggest_financial_concern,
            'amount_for_retirement'     => $member->amount_for_retirement,
            'channels'                  => $member->channels,
            'is_watch'                  => $member->is_watch,
            'total_net_worth'           => $member->total_net_worth,
            'goal'                      => $member->goal,
            'created_at'                => $member->created_at,
            'updated_at'                => $member->updated_at,
            'can_convert'               => $this->canConvertToLead($member->client),
            'is_activated'              => $member->client?->user->deleted_at === null && $member->client?->user->email_verified_at !== null,
            'can_delete'                => $member->client !== null && $member->client->user->deleted_at === null,
            'can_restore'               => $member->client !== null && $member->client->user->deleted_at !== null,
            'owner_id'                  => $member->user->getHashedKey(),
            'is_owner'                  => $member->user->getKey() === $authUser->getKey(),
        ];

        return $this->ifAdmin([
            'real_id'    => $member->id,
            'deleted_at' => $member->deleted_at,
        ], $response);
    }

    public function includeSpouse(Member $member): NullResource | Item
    {
        if ($member->married && $member->spouse !== null) {
            return $this->item($member->spouse, new ContactsTransformer());
        }

        return $this->null();
    }

    public function includeEmploymentHistory(Member $member): Collection | NullResource
    {
        if ($member->employmentHistory->isEmpty()) {
            return $this->null();
        }

        return $this->collection($member->employmentHistory->sortByDesc('updated_at'), new MemberEmploymentHistoryTransformer());
    }

    public function includeHouse(Member $member): Item | NullResource
    {
        if ($member->house === null) {
            return $this->null();
        }

        return $this->item($member->house, new MemberHouseTransformer());
    }

    public function includeOther(Member $member): Item | NullResource
    {
        if ($member->other === null) {
            return $this->null();
        }

        return $this->item($member->other, new MemberOtherTransformer());
    }

    public function includeAvatar(Member $member): Item | NullResource
    {
        return $this->includeMedia($member);
    }

    public function includeContacts(Member $member): Collection
    {
        return $this->collection($member->contacts, new ContactsTransformer());
    }

    private function calculateOnBoarding(Member $member): float
    {
        if ($member->type === Member::LEAD) {
            $member = $member->load('client');

            return round($member->client?->calculateOnBoarding() ?? 0, 2);
        }

        $currentStepOrder = (int)array_search($member->step, MemberStepsEnum::values(), true);
        $stepsCount       = \count(MemberStepsEnum::values()) - 1;

        return round($currentStepOrder / $stepsCount * 100, 2);
    }

    private function canConvertToLead(?Client $client): bool
    {
        if ($client === null) {
            return false;
        }

        return $client->isCompleted();
    }

    public function includeClientUser(Member $member): NullResource|Item
    {
        if ($member->client !== null) {
            return $this->item($member->client->user, new UserTransformer());
        }

        return $this->null();
    }

    public function includeSalesforce(Member $member): Item | NullResource
    {
        if ($member->salesforce === null) {
            return $this->null();
        }

        return $this->item($member->salesforce, new AccountTransformer());
    }

    public function includeOwner(Member $member): Item
    {
        return $this->item($member->user, new UserTransformer());
    }
}
