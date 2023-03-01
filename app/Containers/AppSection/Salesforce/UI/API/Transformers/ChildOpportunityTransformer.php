<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Parents\Transformers\Transformer;

class ChildOpportunityTransformer extends Transformer
{
    public function transform(SalesforceChildOpportunity $childOpportunity): array
    {
        return [
            'id'            => $childOpportunity->getHashedKey(),
            'name'          => $childOpportunity->name,
            'created_date'  => $childOpportunity->created_at->format('Y-m-d'),
            'amount'        => $childOpportunity->amount,
            'type'          => $childOpportunity->type,
            'stage'         => $childOpportunity->stage,
            'close_date'    => $childOpportunity->close_date->format('Y-m-d'),
        ];
    }
}
