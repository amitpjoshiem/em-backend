<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Data\Transporters;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Transporters\Transporter;

class RefreshTransporter extends Transporter
{
    public ?string $refresh_token = null;

    public Request $request;
}
