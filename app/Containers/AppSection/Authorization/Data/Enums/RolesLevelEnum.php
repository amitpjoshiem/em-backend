<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * /**
 * @method static self admin()
 * @method static self advisor()
 * @method static self client()
 * @method static self lead()
 * @method static self ceo()
 * @method static self assistant()
 * @method static self support()
 *
 * @property-read int $value
 */
class RolesLevelEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'ceo'           => 999,
            'admin'         => 900,
            'advisor'       => 100,
            'assistant'     => 99,
            'support'       => 90,
            'client'        => 10,
            'lead'          => 1,
        ];
    }
}
