<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class DeleteRowTransporter extends Transporter
{
    public int $member_id;

    public string $row;

    public string $group;
}
