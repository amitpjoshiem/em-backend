<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;
use App\Ship\Parents\Actions\Action;

class GetSalesforceOpportunityStagesAction extends Action
{
    public function run(): array
    {
        $stages = OpportunityStageEnum::titles();

        unset($stages[OpportunityStageEnum::NONE], $stages[OpportunityStageEnum::CLOSED_WON], $stages[OpportunityStageEnum::CLOSED_LOST]);

        $stages[OpportunityStageEnum::CLOSED] = 'Closed';

        return $stages;
    }
}
