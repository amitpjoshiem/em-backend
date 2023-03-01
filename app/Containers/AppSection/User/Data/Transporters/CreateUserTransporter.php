<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CreateUserTransporter extends Transporter
{
    public string $username;

    public string $email;

    public string $password;

    public ?int $company;
}
