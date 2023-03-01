<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SaveBlueprintNetWorthTransporter extends Transporter
{
    public int $member_id;

    public ?float $market;

    public ?float $liquid;

    public ?float $income_safe;
}
