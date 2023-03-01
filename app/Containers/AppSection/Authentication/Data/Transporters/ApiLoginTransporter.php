<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Transporters;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Transporters\Transporter;

class ApiLoginTransporter extends Transporter
{
    public ?string $username;

    public ?string $email;

    public string $password;

    public Request $request;
}
