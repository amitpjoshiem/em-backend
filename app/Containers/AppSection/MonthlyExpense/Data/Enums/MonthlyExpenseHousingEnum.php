<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class MonthlyExpenseHousingEnum extends Enum
{
    /** @var string */
    public const MORTGAGE_RENT_FEES = 'mortgage_rent_fees';

    /** @var string */
    public const PROPERTY_TAXES_AND_INSURANCE = 'property_taxes_and_insurance';

    /** @var string */
    public const UTILITIES = 'utilities';

    /** @var string */
    public const HOUSEHOLD_IMPROVEMENT = 'household_improvement';

    /** @var string */
    public const HOUSEHOLD_MAINTENANCE = 'household_maintenance';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::MORTGAGE_RENT_FEES,
            self::PROPERTY_TAXES_AND_INSURANCE,
            self::UTILITIES,
            self::HOUSEHOLD_IMPROVEMENT,
            self::HOUSEHOLD_MAINTENANCE,
        ];
    }
}
