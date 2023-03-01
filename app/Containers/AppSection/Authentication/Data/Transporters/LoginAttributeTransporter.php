<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class LoginAttributeTransporter extends Transporter
{
    public ?string $username;

    public string $loginAttribute;
}
