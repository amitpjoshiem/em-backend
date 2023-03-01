<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class AttachPermissionToRoleTransporter extends Transporter
{
    /**
     * @noRector
     *
     * @var int|string
     */
    public $role_id;

    public array $permissions_ids;
}
