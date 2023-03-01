<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UpdateFixedIndexAnnuitiesTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public int $id;

    public ?string $name;

    public ?string $insurance_provider;

    public ?string $tax_qualification;

    public ?string $agent_rep_code;

    public ?int $license_number;
}
