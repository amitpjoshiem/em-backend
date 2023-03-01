<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class AttachPermissionToUserTransporter extends Transporter
{
    public int $user_id;

    public array $permissions_ids;
}
