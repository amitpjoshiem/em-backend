<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class MemberStepsEnum extends Enum
{
    /** @var string */
    public const DEFAULT = 'default';

    /** @var string */
    public const BASIC = 'basic';

    /** @var string */
    public const ASSETS_INCOME  = 'assets_income';

    /** @var string */
    public const MONTHLY_EXPENSE   = 'monthly_expense';

    /** @var string */
    public const ASSETS_ACCOUNTS   = 'assets_accounts';

    /** @var string */
    public const ASSETS_CONSOLIDATION   = 'assets_consolidation';

    /** @var string */
    public const STRESS_TEST = 'member_report';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            0   => self::DEFAULT,
            1   => self::BASIC,
            2   => self::ASSETS_INCOME,
            3   => self::MONTHLY_EXPENSE,
            4   => self::ASSETS_ACCOUNTS,
            5   => self::ASSETS_CONSOLIDATION,
            6   => self::STRESS_TEST,
        ];
    }
}
