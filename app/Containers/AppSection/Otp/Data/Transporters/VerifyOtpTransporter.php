<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class VerifyOtpTransporter extends Transporter
{
    public string $code;
}
