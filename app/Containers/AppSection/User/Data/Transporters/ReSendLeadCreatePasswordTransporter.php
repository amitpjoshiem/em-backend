<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class ReSendLeadCreatePasswordTransporter extends Transporter
{
    public string $email;
}
