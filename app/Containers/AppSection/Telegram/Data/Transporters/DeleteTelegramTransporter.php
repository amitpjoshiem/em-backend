<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class DeleteTelegramTransporter extends Transporter
{
    public int $id;
}
