<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Support\Carbon;

class CreateSalesforceOpportunityTransporter extends Transporter
{
    public int $member_id;

    public Carbon $close_date;

    public string $stage_name;

    public array $additionData = [];
}
