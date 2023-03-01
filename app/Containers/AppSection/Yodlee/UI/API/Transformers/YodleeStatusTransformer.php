<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\UI\API\Transformers;

use App\Containers\AppSection\Yodlee\Data\Transporters\OutputYodleeStatusTransporter;
use App\Ship\Parents\Transformers\Transformer;

class YodleeStatusTransformer extends Transformer
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

    public function transform(OutputYodleeStatusTransporter $status): array
    {
        return $status->toArray();
    }
}
