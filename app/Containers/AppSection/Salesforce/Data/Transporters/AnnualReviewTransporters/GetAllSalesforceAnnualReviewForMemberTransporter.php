<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllSalesforceAnnualReviewForMemberTransporter extends Transporter
{
    public int $member_id;
}
