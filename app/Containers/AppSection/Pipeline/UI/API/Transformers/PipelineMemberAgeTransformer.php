<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class PipelineMemberAgeTransformer extends Transformer
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

    public function transform(array $data): array
    {
        return [
            'start_age'  => $data['startAge'],
            'end_age'    => $data['endAge'],
            'percent'    => $data['count'] * 100,
        ];
    }
}
