<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class MemberOpportunitiesTransformer extends Transformer
{
    public function transform(array $opportunities): array
    {
        return $opportunities;
    }
}
