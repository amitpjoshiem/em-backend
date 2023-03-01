<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UploadStressTestTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public int $member_id;
}
