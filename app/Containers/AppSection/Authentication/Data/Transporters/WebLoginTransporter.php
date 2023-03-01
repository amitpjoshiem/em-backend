<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class WebLoginTransporter extends Transporter
{
    public ?string $email;

    public ?string $username;

    public string $password;

    public bool $remember_me = false;
}
