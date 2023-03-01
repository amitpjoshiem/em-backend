<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetYodleeAccountsTransporter extends Transporter
{
    public int $provider_id;

    public int $member_id;
}
