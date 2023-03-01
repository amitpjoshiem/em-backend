<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class FindFixedIndexAnnuitiesByIdTransporter extends Transporter
{
    public int $id;
}
