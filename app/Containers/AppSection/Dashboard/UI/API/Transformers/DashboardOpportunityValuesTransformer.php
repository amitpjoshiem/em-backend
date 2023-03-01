<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class DashboardOpportunityValuesTransformer extends Transformer
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

    public function transform(array $opportunityAmount): array
    {
        return [
            'period' => $opportunityAmount['period'],
            'amount' => $opportunityAmount['amount'],
        ];
    }
}
