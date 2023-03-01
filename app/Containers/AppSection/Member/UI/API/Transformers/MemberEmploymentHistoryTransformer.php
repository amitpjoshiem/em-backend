<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Ship\Parents\Transformers\Transformer;

class MemberEmploymentHistoryTransformer extends Transformer
{
    public function transform(MemberEmploymentHistory $history): array
    {
        return [
            'id'            => $history->getHashedKey(),
            'company_name'  => $history->company_name,
            'occupation'    => $history->occupation,
            'years'         => $history->years,
        ];
    }
}
