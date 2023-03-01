<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Transporters\Transporter;

class OutputClientInfoTransporter extends Transporter
{
    public Member $member;

    public Client $client;
}
