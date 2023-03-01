<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetSchemaTransporter extends Transporter
{
    public int $member_id;
}
