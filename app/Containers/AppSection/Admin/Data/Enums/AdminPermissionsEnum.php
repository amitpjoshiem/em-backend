<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * @method static self adminHome()
 * @method static self adminEditUser()
 * @method static self adminDeleteUser()
 * @method static self adminRegisterUser()
 * @method static self adminSendUserCreatePassword()
 * @method static self adminListUser()
 */
class AdminPermissionsEnum extends Enum
{
    /** @var string */
    public const ADMIN_HOME    = 'admin.home';

    /** @var string */
    public const ADMIN_EDIT_USER    = 'admin.users.edit';

    /** @var string */
    public const ADMIN_DELETE_USER    = 'admin.users.delete';

    /** @var string */
    public const ADMIN_REGISTER_USER    = 'admin.users.register';

    /** @var string */
    public const ADMIN_SEND_USER_CREATE_PASSWORD    = 'admin.users.send_create_password';

    /** @var string */
    public const ADMIN_LIST_USERS    = 'admin.users.list';

    protected static function values(): array
    {
        return [
            'adminHome'                          => self::ADMIN_HOME,
            'adminEditUser'                      => self::ADMIN_EDIT_USER,
            'adminDeleteUser'                    => self::ADMIN_DELETE_USER,
            'adminRegisterUser'                  => self::ADMIN_REGISTER_USER,
            'adminSendUserCreatePassword'        => self::ADMIN_SEND_USER_CREATE_PASSWORD,
            'adminListUser'                      => self::ADMIN_LIST_USERS,
        ];
    }

    protected static function labels(): array
    {
        return [
            'adminHome'                   => 'Get Access To Admin Home Panel',
            'adminEditUser'               => 'Get Access To Edit User',
            'adminDeleteUser'             => 'Get Access To Delete User',
            'adminRegisterUser'           => 'Get Access To Register',
            'adminSendUserCreatePassword' => 'Get Access To Send Create Password Email',
            'adminListUser'               => 'Get Access To List of Users',
        ];
    }
}
