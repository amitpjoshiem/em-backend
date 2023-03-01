<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetCollectionMediaRulesOutputTransporter extends Transporter
{
    public ?array $allowed_types;

    public int $size;
}
