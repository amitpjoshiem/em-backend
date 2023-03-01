<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CurrentYearClientReportTransporter extends Transporter
{
    public ?float $beginning_balance = null;

    public ?float $interest_credited = null;

    public ?float $withdrawals = null;
}
