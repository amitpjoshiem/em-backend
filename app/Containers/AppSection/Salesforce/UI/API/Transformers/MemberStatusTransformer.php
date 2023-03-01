<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class MemberStatusTransformer extends Transformer
{
    public function transform(bool $status): array
    {
        return [
            'status'    => $status,
        ];
    }
}
