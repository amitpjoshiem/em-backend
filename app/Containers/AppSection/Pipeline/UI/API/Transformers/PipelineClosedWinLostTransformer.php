<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class PipelineClosedWinLostTransformer extends Transformer
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

    public function transform(array $month): array
    {
        return [
            'period'    => $month['period'],
            'win'       => (int)$month['win'],
            'lost'      => (int)$month['lost'],
        ];
    }
}
