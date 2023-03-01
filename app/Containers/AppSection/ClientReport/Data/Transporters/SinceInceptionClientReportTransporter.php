<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SinceInceptionClientReportTransporter extends Transporter
{
    public ?float $total_premiums = null;

    public ?float $bonus_received = null;

    public ?float $interest_credited = null;

    public ?float $total_withdrawals = null;
}
