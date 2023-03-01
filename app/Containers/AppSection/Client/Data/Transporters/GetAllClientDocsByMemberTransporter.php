<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GetAllClientDocsByMemberTransporter extends Transporter
{
    public int $member_id;

    public string $collection;
}
