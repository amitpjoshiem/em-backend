<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class RowAdditionsDataTransporter extends Transporter
{
    public bool $joined = false;

    public bool $can_join = false;

    public bool $married = false;
}
