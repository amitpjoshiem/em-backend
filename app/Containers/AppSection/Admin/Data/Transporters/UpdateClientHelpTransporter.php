<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UpdateClientHelpTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public string $type;

    public ?string $text;
}
