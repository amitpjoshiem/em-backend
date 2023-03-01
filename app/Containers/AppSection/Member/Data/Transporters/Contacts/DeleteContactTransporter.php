<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters\Contacts;

use App\Ship\Parents\Transporters\Transporter;

class DeleteContactTransporter extends Transporter
{
    public int $id;
}
