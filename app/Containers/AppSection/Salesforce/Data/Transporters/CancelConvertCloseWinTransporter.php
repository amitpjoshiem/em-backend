<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CancelConvertCloseWinTransporter extends Transporter
{
    public int $member_id;
}
