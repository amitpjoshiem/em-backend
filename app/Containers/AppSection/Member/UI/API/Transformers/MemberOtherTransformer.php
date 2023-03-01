<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberOther;
use App\Ship\Parents\Transformers\Transformer;

class MemberOtherTransformer extends Transformer
{
    public function transform(MemberOther $memberOther): array
    {
        $response = [
            'id'                    => $memberOther->getHashedKey(),
            'risk'                  => $memberOther->risk,
            'questions'             => $memberOther->questions,
            'retirement'            => $memberOther->retirement,
            'retirement_money'      => $memberOther->retirement_money,
            'work_with_advisor'     => $memberOther->work_with_advisor,
        ];

        return $this->ifAdmin([
            'real_id'    => $memberOther->id,
            // 'deleted_at' => $memberhouse->deleted_at,
        ], $response);
    }
}
