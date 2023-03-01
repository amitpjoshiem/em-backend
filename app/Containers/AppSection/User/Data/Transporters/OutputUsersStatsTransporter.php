<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class OutputUsersStatsTransporter extends Transporter
{
    public array $users;
}
