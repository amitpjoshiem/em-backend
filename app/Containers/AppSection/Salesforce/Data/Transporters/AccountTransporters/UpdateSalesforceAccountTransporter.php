<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\AccountTransporters;

use App\Ship\Parents\Transporters\Transporter;

class UpdateSalesforceAccountTransporter extends Transporter
{
    public int $member_id;
}
