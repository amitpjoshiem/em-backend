<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class MonthlyExpenseHealthcareEnum extends Enum
{
    /** @var string */
    public const HEALTH_INSURANCE = 'health_insurance';

    /** @var string */
    public const MEDICARE_MEDIGAP = 'medicare_medigap';

    /** @var string */
    public const COPAYS_UNCOVERED_MEDICAL_SERVICES = 'copays_uncovered_medical_services';

    /** @var string */
    public const DRUGS_AND_MEDICAL_SUPPLIES = 'drugs_and_medical_supplies';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::HEALTH_INSURANCE,
            self::MEDICARE_MEDIGAP,
            self::COPAYS_UNCOVERED_MEDICAL_SERVICES,
            self::DRUGS_AND_MEDICAL_SUPPLIES,
        ];
    }
}
