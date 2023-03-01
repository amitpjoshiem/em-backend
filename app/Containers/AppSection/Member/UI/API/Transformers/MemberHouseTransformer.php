<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Ship\Parents\Transformers\Transformer;

class MemberHouseTransformer extends Transformer
{
    public function transform(MemberHouse $memberhouse): array
    {
        $response = [
            'id'                                 => $memberhouse->getHashedKey(),
            'type'                               => $memberhouse->type,
            'market_value'                       => $memberhouse->market_value,
            'total_debt'                         => $memberhouse->total_debt,
            'remaining_mortgage_amount'          => $memberhouse->remaining_mortgage_amount,
            'monthly_payment'                    => $memberhouse->monthly_payment,
            'total_monthly_expenses'             => $memberhouse->total_monthly_expenses,
            'updated_at'                         => $memberhouse->updated_at,
            'created_at'                         => $memberhouse->created_at,
        ];

        return $this->ifAdmin([
            'real_id'    => $memberhouse->id,
            // 'deleted_at' => $memberhouse->deleted_at,
        ], $response);
    }
}
