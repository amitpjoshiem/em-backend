<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class CreateInvestmentPackageTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public string $name;

    public int $fixed_index_annuities_id;
}
