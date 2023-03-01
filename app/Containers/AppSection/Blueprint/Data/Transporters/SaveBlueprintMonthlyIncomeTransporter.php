<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SaveBlueprintMonthlyIncomeTransporter extends Transporter
{
    public int $member_id;

    public ?float $current_member;

    public ?float $current_spouse;

    public ?float $current_pensions;

    public ?float $current_rental_income;

    public ?float $current_investment;

    public ?float $future_member;

    public ?float $future_spouse;

    public ?float $future_pensions;

    public ?float $future_rental_income;

    public ?float $future_investment;

    public ?float $tax;

    public ?float $ira_first;

    public ?float $ira_second;
}
