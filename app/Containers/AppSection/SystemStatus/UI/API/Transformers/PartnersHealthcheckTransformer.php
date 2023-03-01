<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\UI\API\Transformers;

use App\Containers\AppSection\SystemStatus\Data\Transporters\PartnersHealthcheckTransporter;
use App\Ship\Parents\Transformers\Transformer;

class PartnersHealthcheckTransformer extends Transformer
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

    public function transform(PartnersHealthcheckTransporter $status): array
    {
        return $status->toArray();
    }
}
