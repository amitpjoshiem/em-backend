<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * @method static self manageRoles()
 * @method static self manageAdminsAccess()
 *
 * @property-read string $value
 */
class AuthorizationPermissionEnum extends Enum
{
    /** @var string */
    public const MANAGE_ROLES         = 'roles.manage';

    /** @var string */
    public const MANAGE_ADMINS_ACCESS = 'admins.manage-access';

    protected static function values(): array
    {
        return [
            'manageRoles'        => self::MANAGE_ROLES,
            'manageAdminsAccess' => self::MANAGE_ADMINS_ACCESS,
        ];
    }

    protected static function labels(): array
    {
        return [
            'manageRoles'        => 'Create, Update, Delete, Get All, Attach/detach permissions to Roles and Get All Permissions.',
            'manageAdminsAccess' => 'Assign users to Roles.',
        ];
    }
}
