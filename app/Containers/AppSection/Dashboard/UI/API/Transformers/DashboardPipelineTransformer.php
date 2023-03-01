<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class DashboardPipelineTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(object $data): array
    {
        return [
            'members'       => $data->members,
            'new_members'   => $data->new_members,
            'aum'           => $data->aum,
            'new_aum'       => $data->new_aum,
        ];
    }
}
