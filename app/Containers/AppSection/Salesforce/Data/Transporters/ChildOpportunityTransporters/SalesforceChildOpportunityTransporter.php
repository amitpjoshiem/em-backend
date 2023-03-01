<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Ship\Parents\Transporters\Transporter;
use Carbon\Carbon;

class SalesforceChildOpportunityTransporter extends Transporter
{
    public string $ownerId;

    public ?string $accountId = null;

    public ?string $parentOpportunityId = null;

    public ?string $name = null;

    public ?string $type = null;

    public ?string $stage = null;

    public Carbon $close_date;

    public ?float $amount = null;
}
