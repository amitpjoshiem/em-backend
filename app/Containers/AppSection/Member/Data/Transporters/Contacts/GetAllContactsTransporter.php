<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Transporters\Contacts;

use App\Ship\Parents\Transporters\Transporter;

class GetAllContactsTransporter extends Transporter
{
    public int $member_id;
}
