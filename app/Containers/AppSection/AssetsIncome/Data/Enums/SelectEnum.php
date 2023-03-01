<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self current_income()
 *
 * @property-read string $value
 */
class SelectEnum extends Enum
{
    /** @var string */
    public const CURRENT_INCOME = 'current_income';

    protected static function values(): array
    {
        return [
            'current_income'            => self::CURRENT_INCOME,
        ];
    }
}
