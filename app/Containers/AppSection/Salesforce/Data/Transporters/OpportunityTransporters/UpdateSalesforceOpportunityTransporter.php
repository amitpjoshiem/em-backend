<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;

class UpdateSalesforceOpportunityTransporter extends Transporter
{
    public int $member_id;

    public ?string $close_date = null;

    public ?string $stage_name = null;
}
