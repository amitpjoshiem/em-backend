<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CreateRowTransporter extends Transporter
{
    public int $member_id;

    public string $group;

    public string $row;

    public ?bool $can_join;

    public ?string $parent;
}
