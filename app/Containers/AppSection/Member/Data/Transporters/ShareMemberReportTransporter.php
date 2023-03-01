<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class ShareMemberReportTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public array $emails;
}
