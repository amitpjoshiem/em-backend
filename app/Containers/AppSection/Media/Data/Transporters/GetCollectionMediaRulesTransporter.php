<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetCollectionMediaRulesTransporter extends Transporter
{
    public string $collection;
}
