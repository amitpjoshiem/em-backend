<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class HouseTransporter extends Transporter
{
    public ?float $total_monthly_expenses;

    public ?float $monthly_payment;

    public ?float $remaining_mortgage_amount;

    public ?float $total_debt;

    public ?float $market_value;

    public ?string $type;
}
