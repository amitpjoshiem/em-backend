<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas;

class AssetsIncomeSchema
{
    /**
     * @var string
     */
    public const CURRENT_INCOME_GROUP = 'current_income';

    /**
     * @var string
     */
    public const LIQUID_ASSETS_GROUP = 'liquid_assets';

    /**
     * @var string
     */
    public const NON_LIQUID_ASSETS_GROUP = 'non_liquid_assets';

    public static function groups(): array
    {
        return [
            self::CURRENT_INCOME_GROUP,
            self::LIQUID_ASSETS_GROUP,
            self::NON_LIQUID_ASSETS_GROUP,
        ];
    }

    public static function groupLabels(): array
    {
        return [
            self::CURRENT_INCOME_GROUP    => 'Current Income',
            self::LIQUID_ASSETS_GROUP     => 'Liquid Assets',
            self::NON_LIQUID_ASSETS_GROUP => 'Non Liquid Assets',
        ];
    }

    public static function getGroupLabel(string $group): string
    {
        $labels = self::groupLabels();

        return $labels[$group];
    }

    public static function getCurrentIncomeFields(): array
    {
        return [
            'salary',
            'social_security',
            'pension',
            'rental_income',
            'rmds',
            'interest_dividends',
            'other',
        ];
    }
}
