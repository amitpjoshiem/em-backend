<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class CreateRoleTransporter extends Transporter
{
    public string $name;

    public ?string $description = null;

    public ?string $display_name = null;

    public int $level = 0;

    public ?string $guard_name = null;
}
