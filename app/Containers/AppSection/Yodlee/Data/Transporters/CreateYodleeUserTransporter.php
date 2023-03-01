<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CreateYodleeUserTransporter extends Transporter
{
    public int $member_id;
}
