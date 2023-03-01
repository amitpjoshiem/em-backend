<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * @method static self search()
 * @method static self list()
 * @method static self update()
 * @method static self delete()
 * @method static self refresh()
 * @method static self createAdmins()
 * @method static self getProfile()
 * @method static self impersonateAdmins()
 *
 * @property-read string $value
 */
class UserPermissionEnum extends Enum
{
    /** @var string */
    public const SEARCH  = 'users.search';

    /** @var string */
    public const LIST    = 'users.list';

    /** @var string */
    public const UPDATE  = 'users.update';

    /** @var string */
    public const DELETE  = 'users.delete';

    /** @var string */
    public const REFRESH = 'users.refresh';

    /** @var string */
    public const GET_PROFILE = 'users.get-profile';

    /** @var string */
    public const CREATE_ADMINS = 'admins.create';

    /** @var string */
    public const IMPERSONATE_ADMINS = 'admins.impersonate';

    /** @var string[] */
    public const PMS_ADVISOR      = [self::UPDATE, self::REFRESH, self::GET_PROFILE];

    protected static function values(): array
    {
        return [
            'search'            => self::SEARCH,
            'list'              => self::LIST,
            'update'            => self::UPDATE,
            'delete'            => self::DELETE,
            'refresh'           => self::REFRESH,
            'createAdmins'      => self::CREATE_ADMINS,
            'getProfile'        => self::GET_PROFILE,
            'impersonateAdmins' => self::IMPERSONATE_ADMINS,
        ];
    }

    protected static function labels(): array
    {
        return [
            'search'            => 'Find a User in the DB.',
            'list'              => 'Get All Users.',
            'update'            => 'Update a User.',
            'delete'            => 'Delete a User.',
            'refresh'           => 'Refresh User data.',
            'createAdmins'      => 'Create new Users (Admins) from the dashboard.',
            'getProfile'        => 'Get Authenticated User Profile info',
            'impersonateAdmins' => 'Impersonate User by ID',
        ];
    }
}
