<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UpdateClientTransporter extends Transporter
{
    public ?bool $terms_and_conditions;
}
