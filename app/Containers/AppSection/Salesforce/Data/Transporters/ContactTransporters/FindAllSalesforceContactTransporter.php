<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ContactTransporters;

use App\Ship\Parents\Transporters\Transporter;

class FindAllSalesforceContactTransporter extends Transporter
{
    public int $member_id;
}
