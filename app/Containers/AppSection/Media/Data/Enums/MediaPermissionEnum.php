<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * @method static self create()
 * @method static self delete()
 * @method static self list()
 *
 * @property-read string $value
 */
class MediaPermissionEnum extends Enum
{
    /** @var string */
    public const CREATE = 'media.create';

    /** @var string */
    public const DELETE = 'media.delete';

    /** @var string */
    public const LIST   = 'media.list';

    protected static function values(): array
    {
        return [
            'create' => self::CREATE,
            'delete' => self::DELETE,
            'list'   => self::LIST,
        ];
    }

    protected static function labels(): array
    {
        return [
            'create' => 'Create Temporary Media',
            'delete' => 'Delete Media',
            'list'   => 'Get All Temporary Media',
        ];
    }
}
