<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UploadAssetsConsolidationsDocsTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;

    public int $member_id;
}
