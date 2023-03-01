<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetBlueprintMonthlyIncomeTransporter extends Transporter
{
    public int $member_id;
}
