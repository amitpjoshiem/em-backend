<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\PercentToFloatCaster;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateAssetsConsolidationsTableTransporter extends Transporter
{
    public int $table_id;

    public ?string $name;

    #[CastWith(PercentToFloatCaster::class)]
    public ?float $wrap_fee;
}
