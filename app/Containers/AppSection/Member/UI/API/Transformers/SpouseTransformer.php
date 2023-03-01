<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\NullResource;

class SpouseTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'employment_history',
    ];

    public function transform(MemberContact $spouse): array
    {
        $response = [
            'id'                  => $spouse->getHashedKey(),
            'first_name'          => $spouse->first_name,
            'last_name'           => $spouse->last_name,
            'email'               => $spouse->email,
            'birthday'            => $spouse->birthday?->format('Y-m-d'),
            'age'                 => $spouse->getAge(),
            'retired'             => $spouse->retired,
            'retirement_date'     => $spouse->retirement_date?->format('Y-m-d'),
            'phone'               => $spouse->phone,
            'created_at'          => $spouse->created_at,
            'updated_at'          => $spouse->updated_at,
        ];

        return $this->ifAdmin([
            'real_id'    => $spouse->id,
            // 'deleted_at' => $spouse->deleted_at,
        ], $response);
    }

    public function includeEmploymentHistory(MemberContact $spouse): Collection | NullResource
    {
        if ($spouse->employmentHistory->isEmpty()) {
            return $this->null();
        }

        return $this->collection($spouse->employmentHistory->sortByDesc('updated_at'), new MemberEmploymentHistoryTransformer());
    }
}
