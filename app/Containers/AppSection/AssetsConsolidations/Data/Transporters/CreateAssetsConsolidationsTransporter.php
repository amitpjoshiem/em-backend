<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CreateAssetsConsolidationsTransporter extends Transporter
{
    public int $member_id;

    public int $table;
}
