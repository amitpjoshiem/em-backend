<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class MonthlyExpenseEnum extends Enum
{
    /** @var string */
    public const HOUSING = 'housing';

    /** @var string */
    public const FOOD_TRANSPORTATION = 'food_transportation';

    /** @var string */
    public const HEALTHCARE = 'healthcare';

    /** @var string */
    public const PERSONAL_INSURANCE = 'personal_insurance';

    /** @var string */
    public const ENTERTAINMENT = 'entertainment';

    /** @var string */
    public const TRAVEL = 'travel';

    /** @var string */
    public const HOBBIES = 'hobbies';

    /** @var string */
    public const FAMILY_CARE_EDUCATION = 'family_care_education';

    /** @var string */
    public const INCOME_TAXES = 'income_taxes';

    /** @var string */
    public const CHARITABLE_CONTRIBUTIONS = 'charitable_contributions';

    /** @var string */
    public const OTHER = 'other';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::HOUSING             => MonthlyExpenseHousingEnum::values(),
            self::FOOD_TRANSPORTATION => MonthlyExpenseFoodTransportationEnum::values(),
            self::HEALTHCARE          => MonthlyExpenseHealthcareEnum::values(),
            self::PERSONAL_INSURANCE  => MonthlyExpensePersonalInsuranceEnum::values(),
            self::ENTERTAINMENT,
            self::TRAVEL,
            self::HOBBIES,
            self::FAMILY_CARE_EDUCATION,
            self::INCOME_TAXES,
            self::CHARITABLE_CONTRIBUTIONS,
            self::OTHER,
        ];
    }
}
