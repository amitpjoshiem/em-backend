<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class ProxyRefreshTransporter extends Transporter
{
    public string $locale;

    public ?string $refresh_token;

    public string $client_ip;

    public int $client_id;

    public string $client_password;

    public string $grant_type = 'refresh_token';

    public string $scope = '';
}
