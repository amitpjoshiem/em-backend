<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Enums;

use App\Ship\Parents\Enums\Enum;

/**
 * Types of existing collections.
 *
 * @method static self current_income()
 * @method static self liquid_assets()
 * @method static self other_assets_investments()
 *
 * @property-read string $value
 */
class GroupsEnum extends Enum
{
    /** @var string */
    public const CURRENT_INCOME = 'current_income';

    /** @var string */
    public const LIQUID_ASSETS = 'liquid_assets';

    /** @var string */
    public const OTHER_ASSETS_INVESTMENTS = 'other_assets_investments';

    protected static function values(): array
    {
        return [
            'current_income'            => self::CURRENT_INCOME,
            'liquid_assets'             => self::LIQUID_ASSETS,
            'other_assets_investments'  => self::OTHER_ASSETS_INVESTMENTS,
        ];
    }

    public static function getLabel(string $name): string
    {
        $labels = [
            self::CURRENT_INCOME           => 'Current Income',
            self::LIQUID_ASSETS            => 'Liquid Assets',
            self::OTHER_ASSETS_INVESTMENTS => 'Other Assets/Investments',
        ];

        return $labels[$name];
    }
}
