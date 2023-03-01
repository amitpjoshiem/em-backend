<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class OutputBlueprintMonthlyIncomeTransporter extends Transporter
{
    public ?int $member_id;

    public ?float $current_member = null;

    public ?float $current_spouse = null;

    public ?float $current_pensions = null;

    public ?float $current_rental_income = null;

    public ?float $current_investment = null;

    public ?float $future_member = null;

    public ?float $future_spouse = null;

    public ?float $future_pensions = null;

    public ?float $future_rental_income = null;

    public ?float $future_investment = null;

    public ?float $total;

    public ?float $tax = null;

    public ?float $ira_first = null;

    public ?float $ira_second = null;

    public ?float $monthly_expenses;

    public ?string $created_at;

    public ?string $updated_at;
}
