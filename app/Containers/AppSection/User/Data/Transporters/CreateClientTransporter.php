<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CreateClientTransporter extends Transporter
{
    public string $email;

    public string $phone;

    public string $name;
}
