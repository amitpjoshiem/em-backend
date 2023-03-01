<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Transformers;

use App\Containers\AppSection\Member\Data\Transporters\OutputMemberStatsTransporter;
use App\Ship\Parents\Transformers\Transformer;

class MemberStatsTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
    ];

    public function transform(OutputMemberStatsTransporter $data): array
    {
        return [
            'count' => $data->count,
            'leads' => $data->leadStatus,
        ];
    }
}
