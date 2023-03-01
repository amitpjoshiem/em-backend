<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class OutputAssetsConsolidationsTransporter extends Transporter
{
    public string $hashId;

    public ?string $name;

    public ?float $percent_of_holdings;

    public ?float $amount;

    public ?float $management_expense;

    public ?float $turnover;

    public ?float $trading_cost;

    public ?float $wrap_fee;

    public ?float $total_cost_percent;

    public ?float $total_cost;

    public ?array $table;
}
