<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Carbon\Carbon;

class CreateExportExcelAssetsConsolidationsTransporter extends Transporter
{
    public int $member_id;

    public int $user_id;

    public string $type;

    public string $filename;

    public string $status;

    public Carbon $created_at;
}
