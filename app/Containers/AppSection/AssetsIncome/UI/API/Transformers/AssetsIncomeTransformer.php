<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use stdClass;

class AssetsIncomeTransformer extends Transformer
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

    public function transform(stdClass $data): array
    {
        return (array)$data;
    }
}
