<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SubmitClientVideoTransporter extends Transporter
{
    public string $type;

    public string $text;
}
