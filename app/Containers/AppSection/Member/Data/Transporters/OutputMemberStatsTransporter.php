<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class OutputMemberStatsTransporter extends Transporter
{
    public array $count;

    public array $leadStatus;
}
