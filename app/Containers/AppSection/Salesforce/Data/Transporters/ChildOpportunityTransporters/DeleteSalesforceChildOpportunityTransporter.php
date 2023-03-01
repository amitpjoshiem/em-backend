<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;

class DeleteSalesforceChildOpportunityTransporter extends Transporter
{
    public string $child_opportunity_id;
}
