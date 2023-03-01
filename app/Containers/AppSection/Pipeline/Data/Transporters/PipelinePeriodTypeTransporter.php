<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class PipelinePeriodTypeTransporter extends Transporter
{
    public string $type;
}
