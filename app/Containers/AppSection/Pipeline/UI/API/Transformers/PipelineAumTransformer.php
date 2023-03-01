<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class PipelineAumTransformer extends Transformer
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
        return $month;
    }
}
