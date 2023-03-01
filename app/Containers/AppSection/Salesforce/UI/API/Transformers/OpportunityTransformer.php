<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

class OpportunityTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'child_opportunities',
    ];

    public function transform(SalesforceOpportunity $opportunity): array
    {
        return [
            'id'                        => $opportunity->getHashedKey(),
            'stage'                     => OpportunityStageEnum::getTitle($opportunity->stage),
            'investment_size'           => $opportunity->investment_size,
            'need_to_update_closed_won' => $this->needToUpdateClosedWon($opportunity),
            'convert_close_win'         => $opportunity->convert_close_win,
        ];
    }

    public function includeChildOpportunities(SalesforceOpportunity $opportunity): Collection
    {
        return $this->collection($opportunity->childOpportunities, new ChildOpportunityTransformer(), 'childOpp');
    }

    public function needToUpdateClosedWon(SalesforceOpportunity $opportunity): bool
    {
        if (
            $opportunity->stage === OpportunityStageEnum::CLOSED_LOST ||
            $opportunity->stage === OpportunityStageEnum::CLOSED_WON
        ) {
            return false;
        }

        /** @var SalesforceChildOpportunity $childOpportunity */
        foreach ($opportunity->childOpportunities as $childOpportunity) {
            if ($childOpportunity->stage !== OpportunityStageEnum::getTitle(OpportunityStageEnum::CLOSED_WON)) {
                return false;
            }
        }

        return true;
    }
}
