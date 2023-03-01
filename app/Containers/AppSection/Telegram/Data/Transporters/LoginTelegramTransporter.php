<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class LoginTelegramTransporter extends Transporter
{
    public string $bot_id;

    public int $telegram_id;
}
