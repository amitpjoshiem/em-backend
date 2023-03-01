<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllClientReportsDocsTransporter extends Transporter
{
    public int $member_id;
}
