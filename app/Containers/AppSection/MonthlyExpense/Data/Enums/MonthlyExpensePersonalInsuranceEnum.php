<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class MonthlyExpensePersonalInsuranceEnum extends Enum
{
    /** @var string */
    public const LIFE_OTHER = 'life_other';

    /** @var string */
    public const LONG_TERM_CARE = 'long_term_care';

    /** @var string */
    public const CLOTHING = 'clothing';

    /** @var string */
    public const PRODUCT_AND_SERVICES = 'product_and_services';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::LIFE_OTHER,
            self::LONG_TERM_CARE,
            self::CLOTHING,
            self::PRODUCT_AND_SERVICES,
        ];
    }
}
