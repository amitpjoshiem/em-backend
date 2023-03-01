<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllMembersTransporter extends Transporter
{
    public ?string $status;
}
