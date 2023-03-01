<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class ProxyApiLoginTransporter extends Transporter
{
    public string $locale;

    public string $client_ip;

    public string $password;

    public ?string $email;

    public ?string $username;

    public int $client_id;

    public string $client_password;

    public string $grant_type = 'password';

    public string $scope = '';
}
