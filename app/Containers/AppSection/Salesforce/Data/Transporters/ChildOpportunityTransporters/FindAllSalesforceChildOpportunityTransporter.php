<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;

class FindAllSalesforceChildOpportunityTransporter extends Transporter
{
    public int $member_id;
}
