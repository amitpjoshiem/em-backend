<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllFixedIndexAnnuitiesTransporter extends Transporter
{
    public int $member_id;
}
