<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllInvestmentPackagesTransporter extends Transporter
{
    public int $fixed_index_annuities_id;
}
