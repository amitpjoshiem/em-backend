<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllBlueprintDocsTransporter extends Transporter
{
    public int $member_id;
}
