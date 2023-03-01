<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Illuminate\Support\Collection;

class OutputInitTransporter extends Transporter
{
    public Collection $roles;

    public Collection $companies;
}
