<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use App\Ship\Transporters\Casters\PercentToFloatCaster;
use Spatie\DataTransferObject\Attributes\CastWith;

class UpdateAssetsConsolidationsTransporter extends Transporter
{
    public int $id;

    public ?string $name;

    public ?float $amount;

    #[CastWith(PercentToFloatCaster::class)]
    public ?float $management_expense;

    #[CastWith(PercentToFloatCaster::class)]
    public ?float $turnover;

    #[CastWith(PercentToFloatCaster::class)]
    public ?float $trading_cost;

    #[CastWith(PercentToFloatCaster::class)]
    public ?float $wrap_fee;
}
