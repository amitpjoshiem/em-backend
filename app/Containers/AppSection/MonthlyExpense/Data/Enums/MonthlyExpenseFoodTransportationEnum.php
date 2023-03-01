<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class MonthlyExpenseFoodTransportationEnum extends Enum
{
    /** @var string */
    public const AT_HOME = 'at_home';

    /** @var string */
    public const DINING_OUT = 'dining_out';

    /** @var string */
    public const VEHICLE_PURCHASES_PAYMENTS = 'vehicle_purchases_payments';

    /** @var string */
    public const AUTO_INSURANCE_AND_TAXES = 'auto_insurance_and_taxes';

    /** @var string */
    public const FUEL_AND_MAINTENANCE = 'fuel_and_maintenance';

    /** @var string */
    public const PUBLIC_TRANSPORTATION = 'public_transportation';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::AT_HOME,
            self::DINING_OUT,
            self::VEHICLE_PURCHASES_PAYMENTS,
            self::AUTO_INSURANCE_AND_TAXES,
            self::FUEL_AND_MAINTENANCE,
            self::PUBLIC_TRANSPORTATION,
        ];
    }
}
