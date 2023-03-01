<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Data\Transporters;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Transporters\Transporter;

class GetAllTelegramsTransporter extends Transporter
{
    public array $_headers;

    public Request $request;
}
