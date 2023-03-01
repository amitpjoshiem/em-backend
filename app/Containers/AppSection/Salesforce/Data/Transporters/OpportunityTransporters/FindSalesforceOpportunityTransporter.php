<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;

class FindSalesforceOpportunityTransporter extends Transporter
{
    public int $member_id;
}
