<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class OutputYodleeStatusTransporter extends Transporter
{
    public bool $yodlee_created = false;

    public bool $link_sent = false;

    public bool $link_used = false;

    public int $link_ttl = 0;

    public int $provider_count = 0;
}
