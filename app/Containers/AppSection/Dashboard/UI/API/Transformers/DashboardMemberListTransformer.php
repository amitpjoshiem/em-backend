<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Transformers;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Parents\Transformers\Transformer;

class DashboardMemberListTransformer extends Transformer
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

    public function transform(SalesforceChildOpportunity $data): array
    {
        return [
            'name'          => $data->member->name,
            'type'          => $data->member->type,
            'stage'         => $data->stage,
            'amount'        => $data->amount,
        ];
    }
}
