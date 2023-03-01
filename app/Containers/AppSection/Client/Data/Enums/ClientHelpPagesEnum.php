<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class ClientHelpPagesEnum extends Enum
{
    /** @var string */
    public const PROSPECT_BASIC = 'prospect_basic';

    /**
     * @var string
     */
    public const PROSPECT_ASSETS_INCOME = 'prospect_assets_income';

    /**
     * @var string
     */
    public const PROSPECT_MONTHLY_EXPENSES = 'prospect_monthly_expenses';

    /**
     * @var string
     */
    public const PROSPECT_EMAIL_HELP = 'prospect_email_help';

    /**
     * @var string
     */
    public const PROSPECT_STEP_2 = 'prospect_step_2';

    /**
     * @var string
     */
    public const PROSPECT_STEP_3 = 'prospect_step_3';

    /**
     * @var string
     */
    public const PROSPECT_STEP_4 = 'prospect_step_4';

    /**
     * @var string
     */
    public const PROSPECT_CONFIRM = 'prospect_confirm';

    /**
     * @var string
     */
    public const PROSPECT_TEST_VIDEO = 'prospect_test_video';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::PROSPECT_BASIC,
            self::PROSPECT_ASSETS_INCOME,
            self::PROSPECT_MONTHLY_EXPENSES,
            self::PROSPECT_EMAIL_HELP,
            self::PROSPECT_STEP_2,
            self::PROSPECT_STEP_3,
            self::PROSPECT_STEP_4,
            self::PROSPECT_CONFIRM,
            self::PROSPECT_TEST_VIDEO,
        ];
    }
}
