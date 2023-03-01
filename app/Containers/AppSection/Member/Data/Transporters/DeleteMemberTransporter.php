<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class DeleteMemberTransporter extends Transporter
{
    public int $id;
}
