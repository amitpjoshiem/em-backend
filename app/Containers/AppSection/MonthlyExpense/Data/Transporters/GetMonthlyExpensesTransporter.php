<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetMonthlyExpensesTransporter extends Transporter
{
    public int $member_id;
}
