<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;

class ContactsTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'employment_history',
    ];

    public function transform(MemberContact $contact): array
    {
        $response = [
            'id'                  => $contact->getHashedKey(),
            'last_name'           => $contact->last_name,
            'first_name'          => $contact->first_name,
            'email'               => $contact->email,
            'birthday'            => $contact->birthday?->format('Y-m-d'),
            'age'                 => $contact->getAge(),
            'retired'             => $contact->retired ?? false,
            'retirement_date'     => $contact->retirement_date?->format('Y-m-d'),
            'phone'               => $contact->phone,
            'is_spouse'           => $contact->is_spouse,
            'created_at'          => $contact->created_at,
            'updated_at'          => $contact->updated_at,
        ];

        return $this->ifAdmin([
            'real_id'    => $contact->id,
            // 'deleted_at' => $spouse->deleted_at,
        ], $response);
    }

    public function includeEmploymentHistory(MemberContact $contact): Collection | NullResource
    {
        if (!$contact->is_spouse || $contact->employmentHistory->isEmpty()) {
            return $this->null();
        }

        return $this->collection($contact->employmentHistory->sortByDesc('updated_at'), new MemberEmploymentHistoryTransformer());
    }
}
