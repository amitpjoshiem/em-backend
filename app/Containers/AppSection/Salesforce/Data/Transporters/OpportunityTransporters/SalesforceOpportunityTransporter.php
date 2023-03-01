<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\OpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;
use Carbon\Carbon;

class SalesforceOpportunityTransporter extends Transporter
{
    public string $ownerId;

    public ?string $accountId = null;

    public ?Carbon $closeDate = null;

    public ?string $name = null;

    public ?string $stageName = null;

    public ?array $additionData = [];
}
