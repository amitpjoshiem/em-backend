<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SaveAssetAllocationTransporter extends Transporter
{
    public int $member_id;

    public ?float $liquidity;

    public ?float $growth;

    public ?float $income;
}
