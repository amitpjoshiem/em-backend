<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetClientDocsTransporter extends Transporter
{
    public string $collection;
}
