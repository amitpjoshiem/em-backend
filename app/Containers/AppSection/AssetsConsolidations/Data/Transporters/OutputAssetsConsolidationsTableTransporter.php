<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Support\Collection;

class OutputAssetsConsolidationsTableTransporter extends Transporter
{
    public string $tableHashId;

    public string $name;

    public ?float $wrap_fee = null;

    public Collection $tableData;
}
