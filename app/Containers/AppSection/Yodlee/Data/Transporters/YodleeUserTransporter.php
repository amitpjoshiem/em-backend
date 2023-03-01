<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleeUserTransporter extends Transporter
{
    public string $loginName;

    public string $email;

    public YodleePreferenceTransporter $preferences;
}
